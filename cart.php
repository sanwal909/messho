<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Meesho</title>
    <link rel="stylesheet" href="assets/css/meesho-exact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <button class="back-btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="page-title">CART</span>
            </div>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step active">
            <div class="step-number">1</div>
            <span>Cart</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-number">2</div>
            <span>Address</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-number">3</div>
            <span>Payment</span>
        </div>
        <div class="step-line"></div>
        <div class="step">
            <div class="step-number">4</div>
            <span>Summary</span>
        </div>
    </div>

    <!-- Cart Items -->
    <div class="cart-container">
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be loaded here -->
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <div class="summary-row">
                <span>Shipping:</span>
                <span class="free">FREE</span>
            </div>
            <div class="summary-row">
                <span>Total Product Price:</span>
                <span id="totalPrice">₹98.00</span>
            </div>
            <div class="summary-row total">
                <span>Order Total:</span>
                <span id="orderTotal">₹98.00</span>
            </div>
        </div>

        <!-- Safety Badge -->
        <div class="safety-badge">
            <div class="safety-icon">
                <i class="fas fa-shield-alt"></i>
                <span>Meesho Safe</span>
            </div>
            <h3>Your Safety, Our Priority</h3>
            <p>We make sure that your package is safe at every point of contact.</p>
            <div class="safety-image">
                <i class="fas fa-truck"></i>
            </div>
        </div>
    </div>

    <!-- Continue Button -->
    <div class="continue-section">
        <div class="price-display">
            <span id="bottomTotal">₹98.00</span>
            <span class="price-details" onclick="togglePriceDetails()">VIEW PRICE DETAILS</span>
        </div>
        <button class="continue-btn" onclick="proceedToAddress()">Continue</button>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
    <script>
        // Load cart items
        async function loadCartItems() {
            try {
                const response = await fetch('api/cart.php');
                const cartData = await response.json();
                
                displayCartItems(cartData.items);
                updateCartSummary(cartData.total);
            } catch (error) {
                console.error('Error loading cart:', error);
            }
        }

        function displayCartItems(items) {
            const container = document.getElementById('cartItems');
            
            if (items.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h3>Your cart is empty</h3>
                        <button onclick="goToHome()">Continue Shopping</button>
                    </div>
                `;
                return;
            }

            container.innerHTML = items.map(item => `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}">
                    <div class="item-details">
                        <h4>${item.name}</h4>
                        <p>₹${item.price} <span class="original-price">₹${item.originalPrice}</span></p>
                        <p>Size: ${item.size}</p>
                        <p>Qty: ${item.quantity}</p>
                    </div>
                    <button class="remove-btn" onclick="removeFromCart(${item.id}, '${item.size}')">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
        }

        function updateCartSummary(total) {
            document.getElementById('totalPrice').textContent = `₹${total}`;
            document.getElementById('orderTotal').textContent = `₹${total}`;
            document.getElementById('bottomTotal').textContent = `₹${total}`;
        }

        function removeFromCart(productId, size) {
            fetch('api/cart.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ productId, size })
            })
            .then(() => {
                loadCartItems();
                updateCartCount();
            });
        }

        function proceedToAddress() {
            window.location.href = 'checkout.php?step=address';
        }

        function goBack() {
            window.history.back() || (window.location.href = 'index.php');
        }

        function goToHome() {
            window.location.href = 'index.php';
        }

        function togglePriceDetails() {
            // Toggle price details visibility
        }

        // Initialize
        loadCartItems();
        updateCartCount();
    </script>
</body>
</html>
