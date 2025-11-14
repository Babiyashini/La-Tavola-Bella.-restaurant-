<?php
// Database connection settings for AWS RDS
$servername = "restaurant-db.cdcmac68u6rx.ap-southeast-1.rds.amazonaws.com";
$username = "admin";
$password = "Vdit8634$";
$dbname = "restaurantdb";

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Database connection failed: " . $conn->connect_error);
    }
    
    // Set charset to utf8
    $conn->set_charset("utf8mb4");
    
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    die("System temporarily unavailable. Please try again later.");
}
?>