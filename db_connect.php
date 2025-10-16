<?php
// Database connection settings for AWS RDS
$servername = "restaurant-db.cdcmac68u6rx.ap-southeast-1.rds.amazonaws.com"; // RDS endpoint
$username = "admin";                  // RDS master username
$password = "Vdit8634$";     // Replace with your RDS password
$dbname = "restaurantdb";            // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Optional for testing
?>
