<?php
$name = htmlspecialchars($_GET['name'] ?? 'Valued Customer');
$order_success = isset($_GET['order']) && $_GET['order'] === 'success';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You | La Tavola Bella</title>

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
    margin: 0;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
    overflow: hidden;
    position: relative;
}

.thankyou-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    padding: 60px 40px;
    border-radius: 30px;
    text-align: center;
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
    max-width: 600px;
    width: 90%;
    position: relative;
    z-index: 10;
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: cardEntrance 0.8s ease-out;
}

@keyframes cardEntrance {
    0% { transform: scale(0.8) translateY(50px); opacity: 0; }
    100% { transform: scale(1) translateY(0); opacity: 1; }
}

.thankyou-card h1 {
    color: var(--primary-color);
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    margin-bottom: 20px;
    animation: textGlow 2s ease-in-out infinite alternate;
}

@keyframes textGlow {
    from { text-shadow: 0 0 20px rgba(255, 107, 107, 0.5); }
    to { text-shadow: 0 0 30px rgba(255, 107, 107, 0.8), 0 0 40px rgba(255, 107, 107, 0.6); }
}

.thankyou-card p {
    font-size: 1.3rem;
    color: var(--dark-color);
    margin-bottom: 30px;
    line-height: 1.6;
}

.success-icon {
    font-size: 4rem;
    color: var(--secondary-color);
    margin-bottom: 20px;
    animation: bounce 1s infinite alternate;
}

@keyframes bounce {
    from { transform: scale(1); }
    to { transform: scale(1.1); }
}

.back-btn {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 16px 40px;
    border: none;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    box-shadow: 0 10px 30px rgba(255, 107, 107, 0.4);
    font-size: 1.1rem;
}

.back-btn:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 15px 40px rgba(255, 107, 107, 0.6);
    color: white;
}

.order-details {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    padding: 20px;
    margin: 25px 0;
    border-left: 5px solid var(--accent-color);
}

.delivery-time {
    font-size: 1.1rem;
    color: var(--primary-color);
    font-weight: 600;
    margin: 15px 0;
}

.confetti {
    position: absolute;
    width: 15px;
    height: 15px;
    background: linear-gradient(45deg, var(--primary-color), var(--accent-color), var(--secondary-color));
    top: -10px;
    animation: fall linear infinite;
    opacity: 0.8;
    border-radius: 50%;
    z-index: 1;
}

@keyframes fall {
    0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
    }
    100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
    }
}

.floating-hearts {
    position: absolute;
    font-size: 1.5rem;
    color: var(--primary-color);
    animation: float 6s ease-in-out infinite;
    z-index: 1;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

@media (max-width: 768px) {
    .thankyou-card {
        padding: 40px 25px;
    }
    
    .thankyou-card h1 {
        font-size: 2.2rem;
    }
    
    .thankyou-card p {
        font-size: 1.1rem;
    }
}
</style>
</head>
<body>
<!-- Floating Hearts -->
<div class="floating-hearts" style="top: 10%; left: 10%; animation-delay: 0s;">❤️</div>
<div class="floating-hearts" style="top: 20%; right: 15%; animation-delay: 1s;">💖</div>
<div class="floating-hearts" style="bottom: 30%; left: 15%; animation-delay: 2s;">✨</div>
<div class="floating-hearts" style="bottom: 20%; right: 10%; animation-delay: 3s;">🎉</div>
<div class="floating-hearts" style="top: 40%; left: 20%; animation-delay: 4s;">🥳</div>

<div class="thankyou-card">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    
    <h1>Thank You, <?= $name ?>! 🎉</h1>
    
    <?php if ($order_success): ?>
    <div class="order-details">
        <p><i class="fas fa-check text-success me-2"></i><strong>Order Confirmed Successfully!</strong></p>
        <p class="mb-2">Your order has been received and is being prepared with love ❤️</p>
    </div>
    
    <div class="delivery-time">
        <i class="fas fa-clock me-2"></i>Estimated Delivery: 30-45 minutes
    </div>
    
    <p class="mb-4">
        We've sent an order confirmation to your phone.<br>
        Get ready for a delicious experience! 🍽️
    </p>
    <?php else: ?>
    <p>Thank you for visiting La Tavola Bella!<br>We appreciate your interest in our culinary creations.</p>
    <?php endif; ?>
    
    <a href="index.php" class="back-btn">
        <i class="fas fa-utensils me-2"></i>Back to Main Menu
    </a>
    
    <div class="mt-4">
        <small class="text-muted">
            Have questions? Call us: <strong>+94 77 123 4567</strong>
        </small>
    </div>
</div>

<script>
// Create confetti effect
const colors = ['#FF6B6B', '#FFD93D', '#6BCB77', '#4D96FF', '#FF6EC7', '#4ECDC4'];
const shapes = ['circle', 'square', 'triangle'];

for(let i = 0; i < 80; i++) {
    const confetti = document.createElement('div');
    confetti.classList.add('confetti');
    
    // Random properties
    const color = colors[Math.floor(Math.random() * colors.length)];
    const shape = shapes[Math.floor(Math.random() * shapes.length)];
    const size = Math.random() * 12 + 8;
    const left = Math.random() * 100;
    const animationDuration = (Math.random() * 3 + 2) + 's';
    const animationDelay = (Math.random() * 5) + 's';
    
    // Apply styles
    confetti.style.left = left + 'vw';
    confetti.style.width = size + 'px';
    confetti.style.height = size + 'px';
    confetti.style.background = color;
    confetti.style.animationDuration = animationDuration;
    confetti.style.animationDelay = animationDelay;
    
    // Shape variations
    if (shape === 'square') {
        confetti.style.borderRadius = '3px';
    } else if (shape === 'triangle') {
        confetti.style.borderRadius = '0';
        confetti.style.clipPath = 'polygon(50% 0%, 0% 100%, 100% 100%)';
    }
    
    document.body.appendChild(confetti);
}

// Add floating animation to existing hearts
document.querySelectorAll('.floating-hearts').forEach((heart, index) => {
    heart.style.animationDelay = (index * 1.5) + 's';
});
</script>
</body>
</html>