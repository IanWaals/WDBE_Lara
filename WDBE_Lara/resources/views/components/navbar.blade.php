<header class="primary-header">
    <div class="brand-logo">Vinyl Vibes</div>
    <nav class="main-navigation">
        <a href="/" class="nav-link">Home</a>
        <a href="/products" class="nav-link">Products</a>
        <a href="/about" class="nav-link">About</a>
        <a href="/contact" class="nav-link">Contact</a>
        
        @if(Session::has('user_id'))
            <!-- Show Admin link only if user has admin role -->
            @if(Session::get('role') === 'admin')
                <a href="/admin" class="nav-link">Admin</a>
            @endif
            
            <!-- Show username and logout when logged in -->
            <a href="/logout" class="nav-link">Logout</a>

            <!-- Shopping Cart Button -->
            <button onclick="toggleCart()" class="nav-link cart-button">
                🛒 Cart (<span id="cartCount">0</span>)
            </button>
        @else
            <!-- Show login when not logged in -->
            <a href="#" onclick="showLoginModal(event)" class="nav-link">Login</a>
        @endif
    </nav>
</header>

<!-- Shopping Cart Modal -->
<div id="cartModal" class="modal-overlay" onclick="closeCartModal(event)">
    <div class="cart-modal-content" onclick="event.stopPropagation()">
        <div class="modal-header">
            <h2>Your Shopping Cart</h2>
            <button class="modal-close" onclick="closeCartModal()">&times;</button>
        </div>
        <div class="cart-modal-body">
            <div id="cartItems"></div>
            <div id="emptyCartMessage" class="empty-cart-message">
                Your cart is empty
            </div>
        </div>
        <div class="cart-modal-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">$0.00</span>
            </div>
            <button onclick="checkout()" class="button button--checkout" id="checkoutBtn" disabled>
                Checkout
            </button>
        </div>
    </div>
</div>

<!-- Login/Register Modals -->
@include('components.loginregister')

<script>
// Shopping Cart Array
let cart = [];

// Load cart from localStorage on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    updateCartDisplay();
});

// Load cart from localStorage
function loadCart() {
    const savedCart = localStorage.getItem('vinylCart');
    if (savedCart) {
        cart = JSON.parse(savedCart);
    }
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('vinylCart', JSON.stringify(cart));
}

// Add item to cart
function addToCart(title, artist, price, image) {
    // Check if item already exists
    const existingItem = cart.find(item => item.title === title && item.artist === artist);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            title: title,
            artist: artist,
            price: parseFloat(price),
            image: image,
            quantity: 1
        });
    }
    
    saveCart();
    updateCartDisplay();
    showNotification('Added to cart!');
}

// Remove item from cart
function removeFromCart(index) {
    cart.splice(index, 1);
    saveCart();
    updateCartDisplay();
}

// Update quantity
function updateQuantity(index, change) {
    cart[index].quantity += change;
    
    if (cart[index].quantity <= 0) {
        removeFromCart(index);
    } else {
        saveCart();
        updateCartDisplay();
    }
}

// Update cart display
function updateCartDisplay() {
    const cartCount = document.getElementById('cartCount');
    const cartItems = document.getElementById('cartItems');
    const emptyMessage = document.getElementById('emptyCartMessage');
    const cartTotal = document.getElementById('cartTotal');
    const checkoutBtn = document.getElementById('checkoutBtn');
    
    // Update cart count
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    
    // Update cart items display
    if (cart.length === 0) {
        cartItems.innerHTML = '';
        emptyMessage.style.display = 'block';
        checkoutBtn.disabled = true;
        cartTotal.textContent = '$0.00';
    } else {
        emptyMessage.style.display = 'none';
        checkoutBtn.disabled = false;
        
        cartItems.innerHTML = cart.map((item, index) => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.title}" class="cart-item__image">
                <div class="cart-item__info">
                    <div class="cart-item__title">${item.title}</div>
                    <div class="cart-item__artist">${item.artist}</div>
                    <div class="cart-item__price">$${item.price.toFixed(2)}</div>
                </div>
                <div class="cart-item__controls">
                    <button onclick="updateQuantity(${index}, -1)" class="quantity-btn">-</button>
                    <span class="cart-item__quantity">${item.quantity}</span>
                    <button onclick="updateQuantity(${index}, 1)" class="quantity-btn">+</button>
                </div>
                <button onclick="removeFromCart(${index})" class="cart-item__remove">×</button>
            </div>
        `).join('');
        
        // Calculate total
        const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        cartTotal.textContent = '$' + total.toFixed(2);
    }
}

// Toggle cart modal
function toggleCart() {
    const cartModal = document.getElementById('cartModal');
    cartModal.classList.toggle('active');
    if (cartModal.classList.contains('active')) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

// Close cart modal
function closeCartModal(event) {
    if (!event || event.target.id === 'cartModal') {
        document.getElementById('cartModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// Checkout function
function checkout() {
    if (cart.length === 0) return;
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Clear cart
    cart = [];
    saveCart();
    updateCartDisplay();
    
    // Close cart modal
    closeCartModal();
    
    // Show success message
    showNotification(`Checkout successful! Total: $${total.toFixed(2)}. Thank you for your purchase!`);
}

// Show notification
function showNotification(message) {
    // Remove existing notification if any
    const existing = document.querySelector('.notification');
    if (existing) {
        existing.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = 'notification notification--show';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('notification--show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Close cart with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeCartModal();
    }
});
</script>