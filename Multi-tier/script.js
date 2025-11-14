// Get menu prices from PHP JSON
const menuPrices = JSON.parse(document.getElementById('menuPrices').textContent || '{}');

// Cart array
let cart = [];

// DOM elements
const cartBtn = document.getElementById('cartBtn');
const cartModal = document.getElementById('cartModal');
const cartItemsDiv = document.getElementById('cartItems');
const cartCountSpan = document.getElementById('cartCount');
const cartInput = document.getElementById('cart_items_input');

// Add item to cart
function addToCart(name) {
    const price = menuPrices[name];
    let item = cart.find(i => i.name === name);
    if (item) {
        item.qty += 1;
    } else {
        cart.push({ name: name, price: price, qty: 1 });
    }
    updateCart();
    showCart();
}

// Remove item from cart
function removeFromCart(name) {
    cart = cart.filter(i => i.name !== name);
    updateCart();
}

// Update cart DOM
function updateCart() {
    cartItemsDiv.innerHTML = '';
    let total = 0;
    cart.forEach(item => {
        const subtotal = item.price * item.qty;
        total += subtotal;

        const div = document.createElement('div');
        div.className = 'd-flex justify-content-between align-items-center mb-2';
        div.innerHTML = `
            <span>${item.name} x ${item.qty}</span>
            <span>LKR ${subtotal.toFixed(2)} <button class="btn btn-sm btn-danger ms-2">X</button></span>
        `;
        div.querySelector('button').onclick = () => removeFromCart(item.name);
        cartItemsDiv.appendChild(div);
    });

    const totalDiv = document.createElement('div');
    totalDiv.className = 'fw-bold d-flex justify-content-between mt-3';
    totalDiv.innerHTML = `<span>Total</span><span>LKR ${total.toFixed(2)}</span>`;
    cartItemsDiv.appendChild(totalDiv);

    cartCountSpan.textContent = cart.reduce((a, b) => a + b.qty, 0);
    cartInput.value = JSON.stringify(cart);
}

// Show cart modal
function showCart() {
    cartModal.classList.remove('d-none');
    cartModal.classList.add('d-flex');
}

// Close cart modal
function closeCart() {
    cartModal.classList.remove('d-flex');
    cartModal.classList.add('d-none');
}

// Click outside modal to close
cartModal.addEventListener('click', (e) => {
    if (e.target === cartModal) closeCart();
});

// Optional: animate cart button on add
function animateCart() {
    cartBtn.classList.add('btn-success');
    setTimeout(() => cartBtn.classList.remove('btn-success'), 300);
}
