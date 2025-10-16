<?php
include 'db_connect.php';
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>La Tavola Bella | Cozy & Fine Dining</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
/* Your existing CSS here */
body{font-family:'Poppins',sans-serif; background:linear-gradient(to bottom right,#fff8f0,#fef3c7); color:#333; scroll-behavior:smooth;}
header{position:relative;height:100vh; background:url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat; display:flex; align-items:center; justify-content:center; text-align:center; color:#fff;}
header::after{content:'';position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.45);}
.hero-content{position:relative;z-index:1; max-width:800px;}
.hero-content h1{font-family:'Playfair Display',serif;font-size:3rem;margin-bottom:15px; letter-spacing:1.5px;}
.hero-content p{font-size:1.2rem;color:#fef3c7;margin-bottom:25px;}
.cta-btn{background:linear-gradient(to right,#d97706,#92400e);color:white;padding:12px 30px;border:none;border-radius:35px;font-weight:600; transition:all 0.3s ease;}
.cta-btn:hover{transform:scale(1.05);background:linear-gradient(to right,#b45309,#78350f);}
nav{background:#fff;position:sticky;top:0;z-index:1000;box-shadow:0 4px 12px rgba(0,0,0,0.08);}
.nav-link{color:#92400e;font-weight:600;}
.nav-link:hover{color:#d97706;}
section{padding:80px 20px;}
h2{text-align:center;font-family:'Playfair Display',serif;font-size:2.4rem;color:#92400e;margin-bottom:50px;}
.menu-card{transition:transform 0.3s, box-shadow 0.3s;}
.menu-card:hover{transform:translateY(-8px);box-shadow:0 15px 30px rgba(0,0,0,0.15);}
.price{color:#92400e;font-weight:600;font-size:1.1rem;margin-bottom:15px;display:inline-block;background:#fff7ed;padding:5px 14px;border-radius:12px;}
#cartBtn{position:fixed;top:20px;right:20px;background:#d97706;color:white;padding:10px 20px;border:none;border-radius:25px;cursor:pointer;z-index:1001;}
#cartModal{position:fixed;top:0;right:-100%;width:100%;max-width:400px;height:100%;background:#fff;transition:0.3s; z-index:1002;overflow-y:auto; box-shadow:-5px 0 20px rgba(0,0,0,0.2);}
#cartModal.active{right:0;}
#cartContent{padding:20px;position:relative;}
.close-cart{position:absolute;top:10px;right:10px;background:#b45309;color:white;border:none;padding:6px 12px;border-radius:12px;cursor:pointer;}
.checkout-btn{width:100%;background:#d97706;color:white;padding:12px;border:none;border-radius:12px;font-weight:600;cursor:pointer;margin-top:10px;}
.checkout-btn:hover{background:#b45309;}
footer{background:#78350f;color:white;text-align:center;padding:40px 20px;margin-top:60px;}
footer a{color:#fcd34d;text-decoration:none;}
</style>
</head>
<body>

<button id="cartBtn">Cart (<span id="cartCount">0</span>)</button>

<header>
    <div class="hero-content" data-aos="fade-up">
        <h1>La Tavola Bella</h1>
        <p>A Cozy Place Where Flavors Feel Like Home</p>
        <button class="cta-btn" onclick="document.getElementById('menu').scrollIntoView({behavior:'smooth'})">View Menu</button>
    </div>
</header>

<nav class="navbar navbar-expand-lg">
  <div class="container justify-content-center">
    <div class="collapse navbar-collapse show">
      <ul class="navbar-nav gap-4">
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#menu">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<section id="about" data-aos="fade-up">
<h2>About Us</h2>
<p class="text-center mx-auto" style="max-width:800px; line-height:1.6; color:#5c3a16;">
At La Tavola Bella, we bring authentic Italian flavors right to your table. Our recipes are crafted with passion and love, offering a warm dining experience for everyone.
</p>
</section>

<section id="menu" data-aos="fade-up">
<h2>Our Signature Dishes</h2>
<div class="container">
<div class="row g-4">
<?php
$sql="SELECT * FROM menu ORDER BY id ASC";
$result=$conn->query($sql);
if($result && $result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        $image_file = htmlspecialchars($row['image_url'], ENT_QUOTES);
        $price = number_format($row['price'],2);
        $image_url = "images/$image_file";
        echo "<div class='col-sm-6 col-md-4 col-lg-3'>";
        echo "<div class='card menu-card h-100'>";
        echo "<img src='$image_url' class='card-img-top' alt='$name'>";
        echo "<div class='card-body text-center'>";
        echo "<h5 class='card-title'>$name</h5>";
        echo "<p class='price'>LKR $price</p>";
        echo "<button class='btn btn-warning' onclick=\"addToCart('$name', $row[price])\">Add to Cart</button>";
        echo "</div></div></div>";
    }
}else{
    echo "<p>No menu items available.</p>";
}
$conn->close();
?>
</div>
</div>
</section>

<footer id="contact">
<p>Opening Hours: 10:00 AM – 11:00 PM | Monday – Sunday</p>
<p>Email: <a href="mailto:latavolabella@gmail.com">latavolabella@gmail.com</a></p>
<p>
<a href="https://linkedin.com/in/babiyashinivaradaraj" target="_blank">LinkedIn</a> | 
<a href="https://github.com/babiyashinivaradaraj" target="_blank">GitHub</a> | 
<a href="https://yourportfolio.com" target="_blank">Portfolio</a>
</p>
<p>&copy; 2025 La Tavola Bella | Crafted with ❤️ by Babi</p>
</footer>

<div id="cartModal">
<div id="cartContent">
<button class="close-cart" onclick="closeCart()">X</button>
<h2>Your Cart</h2>
<div id="cartItems"></div>
<button class="checkout-btn" onclick="checkout()">Proceed to Checkout</button>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init();
let cart = JSON.parse(localStorage.getItem('cart')||'[]');
updateCartCount();
displayCart();

function addToCart(name, price){
    const existing = cart.find(i=>i.name===name);
    if(existing) existing.qty +=1;
    else cart.push({name, price, qty:1});
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    displayCart();
    alert(`${name} added to cart!`);
}

function updateCartCount(){
    document.getElementById('cartCount').innerText = cart.reduce((sum,i)=>sum+i.qty,0);
}

function displayCart(){
    const container=document.getElementById('cartItems');
    if(cart.length===0){container.innerHTML="<p>Your cart is empty.</p>";return;}
    let html="<table class='table'><thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th>Action</th></tr></thead><tbody>";
    let total=0;
    cart.forEach((item,index)=>{
        let subtotal=item.price*item.qty;
        total+=subtotal;
        html+=`<tr>
            <td>${item.name}</td>
            <td>
                <button class='btn btn-sm btn-warning' onclick='changeQty(${index},-1)'>-</button>
                ${item.qty}
                <button class='btn btn-sm btn-warning' onclick='changeQty(${index},1)'>+</button>
            </td>
            <td>${item.price.toFixed(2)}</td>
            <td>${subtotal.toFixed(2)}</td>
            <td><button class='btn btn-sm btn-danger' onclick='removeItem(${index})'>X</button></td>
        </tr>`;
    });
    html+=`<tr><td colspan='3'><strong>Total</strong></td><td colspan='2'>${total.toFixed(2)}</td></tr></tbody></table>`;
    container.innerHTML=html;
}

function changeQty(index,delta){
    cart[index].qty+=delta;
    if(cart[index].qty<1) cart.splice(index,1);
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    displayCart();
}

function removeItem(index){
    cart.splice(index,1);
    localStorage.setItem('cart',JSON.stringify(cart));
    updateCartCount();
    displayCart();
}

function checkout(){
    if(cart.length === 0){
        alert("Your cart is empty!");
        return;
    }
    localStorage.setItem('cart', JSON.stringify(cart)); // Save for order.php
    window.location.href = 'order.php'; // Go to order page
}

function closeCart(){
    document.getElementById('cartModal').classList.remove('active');
}

document.getElementById('cartBtn').addEventListener('click',()=>{document.getElementById('cartModal').classList.add('active');});
</script>

</body>
</html>
