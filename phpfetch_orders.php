<?php
include 'db_connect.php';

$sql = "SELECT * FROM orders ORDER BY order_time DESC";
$result = $conn->query($sql);

$orders = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($orders);

$conn->close();
?>
