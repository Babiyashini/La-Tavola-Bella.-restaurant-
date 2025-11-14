<?php
include 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'])) {
    $order_id = (int)$_POST['order_id'];
    $status = trim($_POST['status']);

    // Allowed statuses
    $allowed_statuses = ['Pending', 'Completed', 'Cancelled'];
    if (!in_array($status, $allowed_statuses)) {
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Invalid status value."]);
        exit;
    }

    // Update order in DB
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $status, $order_id);
        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "new_status" => $status,
                "message" => "Order status updated successfully."
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                "success" => false,
                "message" => "Failed to update order in database."
            ]);
        }
        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Database query preparation failed."
        ]);
    }
} else {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Invalid request."
    ]);
}

$conn->close();
?>
