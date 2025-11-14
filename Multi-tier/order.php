<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// Get and validate cart items
$cart_items_json = $_POST['cart_items'] ?? '[]';
$cart_items = json_decode($cart_items_json, true);

if (json_last_error() !== JSON_ERROR_NONE || !$cart_items || count($cart_items) === 0) {
    die("<script>alert('Your cart is empty!'); window.location.href='index.php';</script>");
}

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $subtotal = $item['price'] * $item['qty'];
    $total += $subtotal;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Place Order | La Tavola Bella</title>

<!-- Bootstrap & Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary-color: #ff6b6b;
    --secondary-color: #4ecdc4;
    --accent-color: #ffd93d;
    --dark-color: #2d3436;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 20px 0;
}

.order-container {
    max-width: 900px;
    margin: 0 auto;
}

.order-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.2);
    overflow: hidden;
    border: none;
}

.order-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 30px;
    text-align: center;
}

.order-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.5rem;
    margin: 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.order-body {
    padding: 40px;
}

.section-title {
    font-family: 'Playfair Display', serif;
    color: var(--dark-color);
    font-size: 1.8rem;
    margin-bottom: 25px;
    border-bottom: 3px solid var(--accent-color);
    padding-bottom: 10px;
}

.order-item {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 15px;
    border-left: 5px solid var(--primary-color);
    transition: all 0.3s ease;
}

.order-item:hover {
    transform: translateX(10px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.total-section {
    background: linear-gradient(135deg, var(--accent-color), #ffed4e);
    border-radius: 15px;
    padding: 25px;
    font-size: 1.3rem;
    font-weight: 700;
    color: var(--dark-color);
    margin: 30px 0;
}

.form-control {
    border-radius: 12px;
    padding: 15px 20px;
    border: 2px solid #e9ecef;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 107, 0.25);
}

.form-label {
    font-weight: 600;
    color: var(--dark-color);
    margin-bottom: 8px;
}

.submit-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border: none;
    color: white;
    padding: 18px 40px;
    font-weight: 600;
    border-radius: 50px;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    width: 100%;
    margin-top: 20px;
    box-shadow: 0 10px 30px rgba(255,107,107,0.4);
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(255,107,107,0.6);
}

.back-btn {
    background: #6c757d;
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 25px;
    text-decoration: none;
    display: inline-block;
    margin-top: 15px;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #5a6268;
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .order-body {
        padding: 25px;
    }
    
    .order-header h1 {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.5rem;
    }
}
</style>
</head>
<body>
<div class="order-container">
    <div class="order-card">
        <div class="order-header">
            <h1><i class="fas fa-clipboard-check me-3"></i>Confirm Your Order</h1>
            <p class="mb-0 mt-2">Almost there! Please review your order details</p>
        </div>
        
        <div class="order-body">
            <!-- Order Summary -->
            <h3 class="section-title">
                <i class="fas fa-receipt me-2"></i>Order Summary
            </h3>
            
            <div class="order-items mb-4">
                <?php foreach ($cart_items as $item): 
                    $subtotal = $item['price'] * $item['qty'];
                ?>
                <div class="order-item">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-1 fw-bold"><?= htmlspecialchars($item['name']) ?></h6>
                            <small class="text-muted">LKR <?= number_format($item['price'], 2) ?> each</small>
                        </div>
                        <div class="col-md-3 text-center">
                            <span class="badge bg-primary fs-6">Qty: <?= $item['qty'] ?></span>
                        </div>
                        <div class="col-md-3 text-end">
                            <strong class="text-success">LKR <?= number_format($subtotal, 2) ?></strong>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Total -->
            <div class="total-section text-center">
                <div class="row align-items-center">
                    <div class="col-md-6 text-start">
                        <i class="fas fa-tag me-2"></i>Grand Total:
                    </div>
                    <div class="col-md-6 text-end">
                        LKR <?= number_format($total, 2) ?>
                    </div>
                </div>
            </div>

            <!-- Customer Information Form -->
            <h3 class="section-title mt-5">
                <i class="fas fa-user-circle me-2"></i>Delivery Information
            </h3>
            
            <form action="order_confirmation.php" method="POST" id="orderForm">
                <input type="hidden" name="cart_items" value='<?= htmlspecialchars(json_encode($cart_items, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP)) ?>'>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Full Name *
                        </label>
                        <input type="text" name="customer_name" class="form-control" 
                               placeholder="Enter your full name" required 
                               pattern="[A-Za-z\s]{2,50}" 
                               title="Please enter a valid name (2-50 characters)">
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <label class="form-label">
                            <i class="fas fa-phone me-2"></i>Phone Number *
                        </label>
                        <input type="tel" name="customer_phone" class="form-control" 
                               placeholder="+94 XX XXX XXXX" required
                               pattern="[\+\d\s\-\(\)]{10,15}"
                               title="Please enter a valid phone number">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Delivery Address *
                    </label>
                    <textarea name="customer_address" class="form-control" 
                              rows="3" placeholder="Enter your complete delivery address" 
                              required minlength="10" 
                              title="Please enter a valid address (at least 10 characters)"></textarea>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">
                        <i class="fas fa-sticky-note me-2"></i>Special Instructions (Optional)
                    </label>
                    <textarea name="special_instructions" class="form-control" 
                              rows="2" placeholder="Any special delivery instructions or notes..."></textarea>
                </div>

                <!-- Order Buttons -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <a href="index.php" class="back-btn w-100 text-center">
                            <i class="fas fa-arrow-left me-2"></i>Back to Menu
                        </a>
                    </div>
                    <div class="col-md-6">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>Place Order
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Form validation
document.getElementById('orderForm').addEventListener('submit', function(e) {
    const inputs = this.querySelectorAll('input[required], textarea[required]');
    let valid = true;
    
    inputs.forEach(input => {
        if (!input.value.trim()) {
            valid = false;
            input.classList.add('is-invalid');
        } else {
            input.classList.remove('is-invalid');
        }
    });
    
    if (!valid) {
        e.preventDefault();
        alert('Please fill in all required fields correctly.');
    }
});

// Real-time validation
document.querySelectorAll('input, textarea').forEach(input => {
    input.addEventListener('input', function() {
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });
});
</script>
</body>
</html>