<?php
// Get the customer's name from URL, default to 'Valued Customer'
$name = htmlspecialchars($_GET['name'] ?? 'Valued Customer');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You | La Tavola Bella</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #fef3c7;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.thankyou-card {
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    text-align: center;
}
.thankyou-card h1 {
    color: #92400e;
    margin-bottom: 20px;
}
.thankyou-card p {
    font-size: 1.2rem;
    margin-bottom: 30px;
}
.back-btn {
    background: #d97706;
    color: white;
    padding: 12px 25px;
    border: none;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
}
.back-btn:hover {
    background: #b45309;
}
</style>
</head>
<body>
<div class="thankyou-card">
    <h1>Thank You, <?= $name ?>!</h1>
    <p>Your order has been successfully placed. We will deliver it shortly.</p>
    <a href="index.php" class="back-btn">Back to Menu</a>
</div>
</body>
</html>
