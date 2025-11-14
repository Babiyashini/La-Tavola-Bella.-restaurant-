<?php
include 'db_connect.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $cart_items_json = $_POST['cart_items'] ?? '[]';
    $cart_items = json_decode($cart_items_json, true);
    
    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_address = trim($_POST['customer_address'] ?? '');
    $customer_phone = trim($_POST['customer_phone'] ?? '');
    $special_instructions = trim($_POST['special_instructions'] ?? '');

    // Validate required fields
    if (empty($customer_name) || empty($customer_address) || empty($customer_phone)) {
        die("<script>alert('All required fields must be filled!'); window.history.back();</script>");
    }

    if (!$cart_items || count($cart_items) === 0) {
        die("<script>alert('Your cart is empty!'); window.location.href='index.php';</script>");
    }

    // Sanitize inputs
    $customer_name = htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8');
    $customer_address = htmlspecialchars($customer_address, ENT_QUOTES, 'UTF-8');
    $customer_phone = htmlspecialchars($customer_phone, ENT_QUOTES, 'UTF-8');
    $special_instructions = htmlspecialchars($special_instructions, ENT_QUOTES, 'UTF-8');

    try {
        // Prepare statement for order insertion
        $stmt = $conn->prepare("
            INSERT INTO orders 
            (customer_name, customer_address, customer_phone, special_instructions, item_name, quantity, price, order_time, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), 'Pending')
        ");
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Insert each cart item as a separate order record
        foreach ($cart_items as $item) {
            $item_name = htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8');
            $quantity = (int)$item['qty'];
            $price = (float)$item['price'];
            
            $stmt->bind_param("ssssisd", 
                $customer_name, 
                $customer_address, 
                $customer_phone, 
                $special_instructions,
                $item_name, 
                $quantity, 
                $price
            );
            
            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }

        $stmt->close();
        
        // Clear the cart after successful order
        echo "<script>localStorage.removeItem('cart');</script>";
        
        // Redirect to thank you page
        header("Location: thankyou.php?name=" . urlencode($customer_name) . "&order=success");
        exit;
        
    } catch (Exception $e) {
        error_log("Order Error: " . $e->getMessage());
        die("<script>alert('Sorry, there was an error processing your order. Please try again.'); window.history.back();</script>");
    }
} else {
    header("Location: index.php");
    exit;
}
?>