<?php
include 'db_connect.php';

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = trim($_POST['customer_name'] ?? '');
    $customer_address = trim($_POST['customer_address'] ?? '');
    $customer_phone = trim($_POST['customer_phone'] ?? '');
    $cart_items = json_decode($_POST['cart_items'] ?? '[]', true);

    if ($customer_name && $customer_address && $customer_phone && !empty($cart_items)) {
        foreach ($cart_items as $item) {
            $stmt = $conn->prepare(
                "INSERT INTO orders (customer_name, customer_address, customer_phone, item_name, price, quantity, order_time, status) VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Pending')"
            );
            $stmt->bind_param("sssddi", $customer_name, $customer_address, $customer_phone, $item['name'], $item['price'], $item['qty']);
            $stmt->execute();
            $stmt->close();
        }
        $message = "✅ Your order has been placed successfully!";
        $message_type = 'success';
        echo "<script>localStorage.removeItem('cart');</script>"; // Clear cart after order
    } else {
        $message = "⚠️ Please fill in all required fields or your cart is empty.";
        $message_type = 'error';
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confirm Your Order | La Tavola Bella</title>
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#fef3c7; padding:20px; }
.order-wrapper { max-width:700px; margin:auto; }
.order-card { background:#fff; padding:25px; border-radius:15px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }
h1 { text-align:center; color:#92400e; margin-bottom:20px; }
.message { text-align:center; padding:12px; margin-bottom:20px; font-weight:600; border-radius:8px; }
.message.success { background:#d1fae5; color:#065f46; }
.message.error { background:#fee2e2; color:#991b1b; }
.order-summary { background:#fff7ed; padding:15px; border-radius:12px; margin-bottom:20px; font-weight:600; }
.order-summary table { width:100%; border-collapse:collapse; }
.order-summary th, td { padding:8px; border-bottom:1px solid #ddd; text-align:center; }
.form-group { margin-bottom:15px; }
.form-group label { display:block; margin-bottom:5px; font-weight:600; }
.form-group input { width:100%; padding:10px; border:1px solid #ddd; border-radius:8px; }
.confirm-btn { background:#d97706; color:white; width:100%; padding:12px; border:none; border-radius:12px; font-size:1rem; font-weight:600; cursor:pointer; }
.confirm-btn:hover { background:#b45309; }
.back-link { display:block; margin-top:15px; text-align:center; color:#92400e; text-decoration:none; }
.back-link:hover { color:#d97706; }
</style>
</head>
<body>

<div class="order-wrapper">
    <div class="order-card" data-aos="fade-up">
        <h1>Confirm Your Order</h1>

        <?php if($message): ?>
            <div class="message <?= $message_type ?>"><?= $message ?></div>
            <a href="index.php" class="back-link">← Back to Menu</a>
        <?php else: ?>

        <!-- Order Summary -->
        <div class="order-summary" id="orderSummary"></div>

        <!-- Customer Form -->
        <form method="POST" action="order.php" id="orderForm">
            <input type="hidden" name="cart_items" id="cart_items">
            <div class="form-group">
                <label for="customer_name">Full Name</label>
                <input type="text" id="customer_name" name="customer_name" placeholder="Enter your full name" required autofocus>
            </div>
            <div class="form-group">
                <label for="customer_address">Delivery Address</label>
                <input type="text" id="customer_address" name="customer_address" placeholder="Enter your address" required>
            </div>
            <div class="form-group">
                <label for="customer_phone">Phone Number</label>
                <input type="tel" id="customer_phone" name="customer_phone" placeholder="+94 77 123 4567" required>
            </div>
            <button type="submit" class="confirm-btn">Place My Order</button>
        </form>

        <a href="index.php" class="back-link">← Back to Menu</a>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init();

// Load cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart') || '[]');
document.getElementById('cart_items').value = JSON.stringify(cart);

// Display cart summary
const summaryDiv = document.getElementById('orderSummary');
if(cart.length > 0){
    let html = "<table><tr><th>Item</th><th>Qty</th><th>Price (LKR)</th><th>Subtotal</th></tr>";
    let total = 0;
    cart.forEach(item => {
        let subtotal = item.price * item.qty;
        total += subtotal;
        html += `<tr>
                    <td>${item.name}</td>
                    <td>${item.qty}</td>
                    <td>${item.price.toFixed(2)}</td>
                    <td>${subtotal.toFixed(2)}</td>
                 </tr>`;
    });
    html += `<tr><td colspan="3"><strong>Total</strong></td><td><strong>LKR ${total.toFixed(2)}</strong></td></tr></table>`;
    summaryDiv.innerHTML = html;
} else {
    summaryDiv.innerHTML = "<p>Your cart is empty.</p>";
}
</script>

</body>
</html>
