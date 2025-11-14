<?php
include 'db_connect.php';
header('Content-Type: application/json; charset=utf-8');

// Check database connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

// Fetch all orders (newest first)
$sql = "SELECT id, customer_name, customer_address, customer_phone, item_name, quantity, price, order_time, status 
        FROM orders 
        ORDER BY order_time DESC";

$result = $conn->query($sql);
$orders = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Sanitize output to prevent XSS
        $orders[] = [
            'id' => (int)$row['id'],
            'customer_name' => htmlspecialchars($row['customer_name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'customer_address' => htmlspecialchars($row['customer_address'] ?? '', ENT_QUOTES, 'UTF-8'),
            'customer_phone' => htmlspecialchars($row['customer_phone'] ?? '', ENT_QUOTES, 'UTF-8'),
            'item_name' => htmlspecialchars($row['item_name'] ?? '', ENT_QUOTES, 'UTF-8'),
            'quantity' => (int)$row['quantity'],
            'price' => (float)$row['price'],
            'order_time' => htmlspecialchars($row['order_time'] ?? '', ENT_QUOTES, 'UTF-8'),
            'status' => htmlspecialchars($row['status'] ?? 'Pending', ENT_QUOTES, 'UTF-8')
        ];
    }
}

// Return orders as JSON
echo json_encode($orders, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
$conn->close();
?>