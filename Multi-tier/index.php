sudo tee /var/www/html/index.php << 'EOF'
<?php 
include 'db_connect.php';

// S3 Bucket base URL for images
$s3_base_url = "https://babi-multitier-webapp.s3.ap-southeast-1.amazonaws.com/";

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>La Tavola Bella | Cozy & Fine Dining</title>

<!-- Bootstrap & AOS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
    --primary-color: #ff6b6b;
    --secondary-color: #4ecdc4;
    --accent-color: #ffd93d;
    --dark-color: #2d3436;
    --light-color: #f7f7f7;
    --gradient-primary: linear-gradient(135deg, #ff6b6b, #ff8e8e);
    --gradient-secondary: linear-gradient(135deg, #4ecdc4, #67e6dc);
    --gradient-accent: linear-gradient(135deg, #ffd93d, #ffed4e);
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    overflow-x: hidden;
}

/* Hero Section - Enhanced */
.hero-section {
    background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('<?php echo $s3_base_url; ?>bg_pic.jpg') center/cover fixed;
    position: relative;
    color: white;
    text-align: center;
    padding: 180px 20px;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-section h1 {
    font-family: 'Playfair Display', serif;
    font-size: 4.5rem;
    background: linear-gradient(45deg, #ffd93d, #ff6b6b);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 20px;
    animation: glow 2s ease-in-out infinite alternate;
}

@keyframes glow {
    from { text-shadow: 0 0 20px #ffd93d; }
    to { text-shadow: 0 0 30px #ff6b6b, 0 0 40px #ff6b6b; }
}

.hero-section p {
    font-size: 1.5rem;
    color: #fff;
    margin-bottom: 40px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.hero-btn {
    background: var(--gradient-primary);
    border: none;
    color: white;
    padding: 18px 45px;
    font-weight: 600;
    border-radius: 50px;
    font-size: 1.2rem;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(255,107,107,0.4);
    position: relative;
    overflow: hidden;
}

.hero-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(255,107,107,0.6);
}

.hero-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: left 0.5s;
}

.hero-btn:hover::before {
    left: 100%;
}

/* Enhanced Navbar */
.navbar {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    box-shadow: 0 5px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.navbar.scrolled {
    background: rgba(255, 255, 255, 0.98);
    padding: 10px 0;
}

.nav-link {
    font-weight: 600;
    color: var(--dark-color) !important;
    transition: all 0.3s ease;
    position: relative;
    margin: 0 10px;
}

.nav-link::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    width: 0;
    height: 3px;
    background: var(--gradient-primary);
    transition: all 0.3s ease;
    transform: translateX(-50%);
    border-radius: 2px;
}

.nav-link:hover::after {
    width: 100%;
}

.nav-link:hover {
    color: var(--primary-color) !important;
    transform: translateY(-2px);
}

/* Enhanced Cart Button */
.cart-btn {
    background: var(--gradient-primary);
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(255,107,107,0.3);
    position: relative;
}

.cart-btn:hover {
    background: var(--gradient-primary);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255,107,107,0.4);
}

.cart-count {
    background: var(--accent-color);
    color: var(--dark-color);
    border-radius: 50%;
    padding: 2px 8px;
    font-size: 0.8rem;
    margin-left: 5px;
    animation: bounce 1s infinite alternate;
}

@keyframes bounce {
    from { transform: scale(1); }
    to { transform: scale(1.1); }
}

/* Section Titles */
.section-title {
    font-family: 'Playfair Display', serif;
    font-size: 3rem;
    background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 50px;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 4px;
    background: var(--gradient-primary);
    border-radius: 2px;
}

/* Enhanced Menu Cards */
.menu-card {
    border: none;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.4s ease;
    background: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    position: relative;
}

.menu-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--gradient-primary);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.menu-card:hover::before {
    transform: scaleX(1);
}

.menu-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

.menu-card img {
    height: 250px;
    object-fit: cover;
    transition: transform 0.4s ease;
    width: 100%;
}

.menu-card:hover img {
    transform: scale(1.1);
}

.card-body {
    padding: 25px;
    text-align: center;
}

.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.4rem;
    color: var(--dark-color);
    margin-bottom: 15px;
    font-weight: 600;
}

.price {
    font-weight: 700;
    color: var(--primary-color);
    font-size: 1.3rem;
    margin-bottom: 15px;
}

.add-to-cart-btn {
    background: var(--gradient-secondary);
    border: none;
    color: white;
    padding: 12px 25px;
    border-radius: 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    width: 100%;
    box-shadow: 0 5px 15px rgba(78,205,196,0.3);
}

.add-to-cart-btn:hover {
    background: var(--gradient-secondary);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(78,205,196,0.4);
}

/* About Section */
.about-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.about-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,0 1000,1000"/></svg>');
}

/* Footer */
footer {
    background: linear-gradient(135deg, var(--dark-color), #1a1a1a);
    color: white;
    padding: 60px 20px 30px;
    position: relative;
}

footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: var(--gradient-primary);
}

.social-links a {
    color: white;
    font-size: 1.5rem;
    margin: 0 15px;
    transition: all 0.3s ease;
    display: inline-block;
}

.social-links a:hover {
    color: var(--accent-color);
    transform: translateY(-5px) scale(1.2);
}

/* Cart Modal */
.cart-modal {
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(10px);
}

.cart-content {
    background: white;
    border-radius: 25px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { transform: translateY(100px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.cart-item {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
    transition: all 0.3s ease;
}

.cart-item:hover {
    background: #f8f9fa;
    transform: translateX(10px);
}

/* Floating Animation */
.floating {
    animation: floating 3s ease-in-out infinite;
}

@keyframes floating {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-20px); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-section h1 { font-size: 2.8rem; }
    .hero-section p { font-size: 1.2rem; }
    .section-title { font-size: 2.2rem; }
    .menu-card img { height: 200px; }
}

/* Loading Animation */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
</head>
<body>

<!-- Hero Section -->
<section class="hero-section" data-aos="fade-down">
    <div class="container">
        <h1 class="floating">La Tavola Bella</h1>
        <p>Where Every Meal Tells a Beautiful Story ✨</p>
        <button class="hero-btn" onclick="document.getElementById('menu').scrollIntoView({behavior:'smooth'})">
            Explore Our Menu <i class="fas fa-chevron-down ml-2"></i>
        </button>
    </div>
</section>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav gap-4">
                <li class="nav-item"><a href="#about" class="nav-link">About Us</a></li>
                <li class="nav-item"><a href="#menu" class="nav-link">Our Menu</a></li>
                <li class="nav-item"><a href="#contact" class="nav-link">Contact</a></li>
                <li class="nav-item">
                    <button id="cartBtn" class="cart-btn">
                        <i class="fas fa-shopping-cart"></i> Cart 
                        <span id="cartCount" class="cart-count">0</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- About Section -->
<section id="about" class="py-5 about-section" data-aos="fade-up">
    <div class="container text-center text-white">
        <h2 class="section-title">Our Story</h2>
        <p style="max-width:850px; margin:auto; line-height:1.8; font-size:1.2rem;">
            At <strong>La Tavola Bella</strong>, we believe dining is an experience that engages all senses. 
            Our chefs craft each dish with passion, using the finest ingredients to create memorable 
            culinary journeys. From traditional Italian classics to innovative fusion creations, 
            every plate tells a story of love, tradition, and innovation. 
            <span class="d-block mt-3">❤️ Crafted with Love, Served with Passion ✨</span>
        </p>
    </div>
</section>

<!-- Menu Section -->
<section id="menu" class="py-5" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center section-title">Culinary Masterpieces</h2>
        <div class="row g-4 justify-content-center">
            <?php
            $menu_items = [];
            $sql = "SELECT * FROM menu ORDER BY id ASC";
            $result = $conn->query($sql);

            if($result && $result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $name = htmlspecialchars($row['name'], ENT_QUOTES);
                    $price = number_format($row['price'], 2);
                    $image_url = $s3_base_url . htmlspecialchars($row['image_url'], ENT_QUOTES);
                    $description = htmlspecialchars($row['description'] ?? 'Delicious dish crafted with love', ENT_QUOTES);
                    $menu_items[$name] = (float)$row['price'];

                    echo "
                    <div class='col-sm-6 col-md-4 col-lg-3'>
                        <div class='card menu-card h-100' data-aos='fade-up' data-aos-delay='100'>
                            <img src='$image_url' alt='$name' class='card-img-top'>
                            <div class='card-body text-center'>
                                <h5 class='card-title'>$name</h5>
                                <p class='text-muted small'>$description</p>
                                <p class='price'>LKR $price</p>
                                <button class='add-to-cart-btn' onclick=\"addToCart('$name')\">
                                    <i class='fas fa-plus'></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                echo "
                <div class='col-12 text-center'>
                    <div class='alert alert-warning' role='alert'>
                        <i class='fas fa-utensils me-2'></i>Menu updating soon! Please check back later.
                    </div>
                </div>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</section>

<!-- Contact & Footer -->
<footer id="contact">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h4 class="mb-4" style="color: var(--accent-color);">Visit Us Today!</h4>
                <p class="mb-3">
                    <i class="fas fa-clock me-2"></i>Opening Hours: 10:00 AM – 11:00 PM | Mon – Sun
                </p>
                <p class="mb-3">
                    <i class="fas fa-envelope me-2"></i>Email: 
                    <a href="mailto:latavolabella@gmail.com" style="color: var(--accent-color);">
                        latavolabella@gmail.com
                    </a>
                </p>
                <p class="mb-4">
                    <i class="fas fa-phone me-2"></i>Phone: +94 77 123 4567
                </p>
                
                <div class="social-links mb-4">
                    <a href="https://linkedin.com/in/babiyashinivaradaraj" target="_blank" title="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="https://github.com/babiyashinivaradaraj" target="_blank" title="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                    <a href="https://yourportfolio.com" target="_blank" title="Portfolio">
                        <i class="fas fa-briefcase"></i>
                    </a>
                    <a href="#" title="Facebook">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                
                <p class="mb-0" style="color: #ccc;">
                    &copy; 2025 La Tavola Bella | Crafted with <i class="fas fa-heart" style="color: var(--primary-color);"></i> by Babi
                </p>
            </div>
        </div>
    </div>
</footer>

<!-- Cart Modal -->
<div id="cartModal" class="modal fade cart-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content cart-content">
            <div class="modal-header border-0">
                <h5 class="modal-title">
                    <i class="fas fa-shopping-cart me-2"></i>Your Cart
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="cartItems"></div>
                <div id="cartEmpty" class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Your cart is empty</p>
                </div>
            </div>
            <div class="modal-footer border-0">
                <form id="checkoutForm" method="POST" action="order.php" class="w-100">
                    <input type="hidden" name="cart_items" id="cart_items_input">
                    <button type="submit" class="btn btn-success w-100 py-3" id="checkoutBtn" disabled>
                        <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="menuPrices" type="application/json"><?php echo json_encode($menu_items); ?></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
// Initialize AOS
AOS.init({
    duration: 1000,
    once: true,
    offset: 100
});

// Cart functionality
let cart = JSON.parse(localStorage.getItem('cart')) || [];
const menuPrices = JSON.parse(document.getElementById('menuPrices').textContent);

function updateCartCount() {
    const count = cart.reduce((total, item) => total + item.qty, 0);
    document.getElementById('cartCount').textContent = count;
}

function addToCart(itemName) {
    const existingItem = cart.find(item => item.name === itemName);
    
    if (existingItem) {
        existingItem.qty += 1;
    } else {
        cart.push({
            name: itemName,
            price: menuPrices[itemName],
            qty: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    showNotification(`${itemName} added to cart!`);
    updateCartModal();
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'position-fixed top-0 start-50 translate-middle-x mt-3 alert alert-success alert-dismissible fade show';
    notification.style.zIndex = '9999';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

function updateCartModal() {
    const cartItems = document.getElementById('cartItems');
    const cartEmpty = document.getElementById('cartEmpty');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const cartInput = document.getElementById('cart_items_input');
    
    if (cart.length === 0) {
        cartItems.innerHTML = '';
        cartEmpty.style.display = 'block';
        checkoutBtn.disabled = true;
        return;
    }
    
    cartEmpty.style.display = 'none';
    checkoutBtn.disabled = false;
    
    let total = 0;
    let itemsHTML = '';
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.qty;
        total += itemTotal;
        
        itemsHTML += `
            <div class="cart-item">
                <div class="row align-items-center">
                    <div class="col-6">
                        <strong>${item.name}</strong>
                        <br>
                        <small class="text-muted">LKR ${item.price.toFixed(2)} each</small>
                    </div>
                    <div class="col-3">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, -1)">-</button>
                            <span class="btn btn-outline-primary disabled">${item.qty}</span>
                            <button class="btn btn-outline-secondary" onclick="updateQuantity(${index}, 1)">+</button>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <strong>LKR ${itemTotal.toFixed(2)}</strong>
                        <br>
                        <button class="btn btn-sm btn-outline-danger mt-1" onclick="removeFromCart(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    itemsHTML += `
        <div class="cart-total border-top pt-3 mt-3">
            <div class="row">
                <div class="col-6">
                    <strong>Total:</strong>
                </div>
                <div class="col-6 text-end">
                    <strong class="text-success">LKR ${total.toFixed(2)}</strong>
                </div>
            </div>
        </div>
    `;
    
    cartItems.innerHTML = itemsHTML;
    cartInput.value = JSON.stringify(cart);
}

function updateQuantity(index, change) {
    cart[index].qty += change;
    
    if (cart[index].qty <= 0) {
        cart.splice(index, 1);
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartModal();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateCartModal();
}

// Initialize cart modal
document.getElementById('cartBtn').addEventListener('click', function() {
    updateCartModal();
    new bootstrap.Modal(document.getElementById('cartModal')).show();
});

// Navbar scroll effect
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Initialize cart on page load
updateCartCount();
</script>
</body>
</html>
EOF