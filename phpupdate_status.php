<?php
include 'db_connect.php';

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['order_id'], $_POST['status'])){
    $order_id = (int)$_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $order_id);
    if($stmt->execute()){
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
$conn->close();
?>
