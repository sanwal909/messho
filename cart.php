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
    <title>Shopping Cart - Meesho</title>
    <link rel="stylesheet" href="assets/css/meesho-exact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <button onclick="window.history.back()" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="logo">
                <span class="logo-text">meesho</span>
            </div>
            <div class="header-icons">
                <i class="fas fa-heart"></i>
                <div class="cart-icon">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count" id="cart-count">0</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Cart Container -->
    <div class="cart-container">
        <!-- Checkout Progress -->
        <div class="checkout-progress">
            <div class="progress-steps">
                <div class="progress-step">
                    <div class="step-number active">1</div>
                    <div class="step-label active">Cart</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">2</div>
                    <div class="step-label">Address</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">3</div>
                    <div class="step-label">Payment</div>
                </div>
                <div class="progress-step">
                    <div class="step-number">4</div>
                    <div class="step-label">Summary</div>
                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="cart-items" id="cartItems">
            <!-- Cart items will be loaded here -->
        </div>

        <!-- Cart Safety -->
        <div class="cart-safety">
            <div class="safety-badge">SAFE</div>
            <div class="safety-title">Your money is safe with us!</div>
            <div class="safety-text">
                We use industry-standard encryption to protect your payment information.
                Your order is 100% secure and your money is safe.
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary" id="orderSummary" style="display: none;">
            <div class="summary-header">
                <h3>Price Details</h3>
            </div>
            <div class="summary-content">
                <div class="summary-row">
                    <span class="summary-label">Price (<span id="itemCount">0</span> item)</span>
                    <span class="summary-value" id="itemsPrice">₹0</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Discount</span>
                    <span class="summary-value discount-value" id="discountValue">₹0</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Delivery Charges</span>
                    <span class="summary-value free-delivery">FREE Delivery</span>
                </div>
                <div class="summary-divider"></div>
                <div class="summary-row total-row">
                    <span class="summary-label">Total Amount</span>
                    <span class="summary-value" id="finalTotal">₹0</span>
                </div>
                <div class="savings-info" id="savingsInfo" style="display: none;">
                    <span>You will save <span class="savings-amount" id="savingsAmount">₹0</span> on this order</span>
                </div>
            </div>
        </div>

        <!-- Empty Cart State -->
        <div class="empty-cart" id="emptyCart" style="display: none;">
            <i class="fas fa-shopping-bag"></i>
            <h3>Your cart is empty</h3>
            <p>Add some products to get started</p>
            <button onclick="navigateTo('index.php')">Continue Shopping</button>
        </div>
    </div>

    <!-- Cart Total -->
    <div class="cart-total" id="cartTotal" style="display: none;">
        <button class="continue-shopping-btn" onclick="proceedToCheckout()">
            Continue to Address
        </button>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="nav-item" onclick="navigateTo('index.php')">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-th-large"></i>
            <span>Categories</span>
        </div>
        <div class="nav-item active">
            <i class="fas fa-shopping-bag"></i>
            <span>Cart</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </div>
    </nav>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
    <script>
        async function loadCartItems() {
            try {
                const cartData = await getCartContents();
                const cartItemsContainer = document.getElementById('cartItems');
                const emptyCart = document.getElementById('emptyCart');
                const cartTotal = document.getElementById('cartTotal');
                const orderSummary = document.getElementById('orderSummary');

                if (!cartData.items || cartData.items.length === 0) {
                    cartItemsContainer.style.display = 'none';
                    emptyCart.style.display = 'block';
                    cartTotal.style.display = 'none';
                    orderSummary.style.display = 'none';
                    return;
                }

                cartItemsContainer.style.display = 'block';
                emptyCart.style.display = 'none';
                cartTotal.style.display = 'block';
                orderSummary.style.display = 'block';

                cartItemsContainer.innerHTML = '';

                let totalOriginalPrice = 0;
                let totalItems = 0;

                cartData.items.forEach(item => {
                    totalOriginalPrice += (item.product.originalPrice || item.product.price) * item.quantity;
                    totalItems += item.quantity;

                    const cartItemHTML = `
                        <div class="cart-item" data-product-id="${item.product.id}" data-size="${item.size}">
                            <div class="cart-item-image">
                                <img src="${item.product.image}" alt="${item.product.name}">
                            </div>
                            <div class="cart-item-details">
                                <div class="cart-item-name">${item.product.name}</div>
                                <div class="cart-item-price">
                                    ₹${item.product.price}
                                    <span class="cart-item-original-price">₹${item.product.originalPrice}</span>
                                </div>
                                <div class="cart-item-size">Size: ${item.size}</div>
                                <div class="cart-item-quantity">
                                    <button class="qty-btn" onclick="updateQuantity(${item.product.id}, '${item.size}', ${item.quantity - 1})" ${item.quantity <= 1 ? 'disabled' : ''}>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <span class="qty-display">${item.quantity}</span>
                                    <button class="qty-btn" onclick="updateQuantity(${item.product.id}, '${item.size}', ${item.quantity + 1})">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="remove-item" onclick="removeFromCart(${item.product.id}, '${item.size}')">
                                <i class="fas fa-trash"></i>
                            </div>
                        </div>
                    `;
                    cartItemsContainer.innerHTML += cartItemHTML;
                });

                // Update order summary
                const discount = totalOriginalPrice - cartData.total;
                document.getElementById('itemCount').textContent = totalItems;
                document.getElementById('itemsPrice').textContent = `₹${totalOriginalPrice}`;
                document.getElementById('discountValue').textContent = `₹${discount}`;
                document.getElementById('finalTotal').textContent = `₹${cartData.total}`;

                // Show savings info if there's a discount
                const savingsInfo = document.getElementById('savingsInfo');
                const savingsAmount = document.getElementById('savingsAmount');
                if (discount > 0) {
                    savingsAmount.textContent = `₹${discount}`;
                    savingsInfo.style.display = 'block';
                } else {
                    savingsInfo.style.display = 'none';
                }

            } catch (error) {
                console.error('Error loading cart:', error);
            }
        }

        async function updateQuantity(productId, size, newQuantity) {
            try {
                if (newQuantity <= 0) {
                    await removeFromCart(productId, size);
                } else {
                    await updateCartQuantity(productId, size, newQuantity);
                    await loadCartItems();
                    await updateCartCount();
                }
            } catch (error) {
                console.error('Error updating quantity:', error);
                showNotification('Error updating quantity', 'error');
            }
        }

        async function removeFromCart(productId, size) {
            try {
                await removeProductFromCart(productId, size);
                await loadCartItems();
                await updateCartCount();
                showNotification('Item removed from cart');
            } catch (error) {
                console.error('Error removing item:', error);
            }
        }

        function proceedToCheckout() {
            window.location.href = 'checkout.php';
        }

        // Load cart on page load
        document.addEventListener('DOMContentLoaded', async () => {
            await loadCartItems();
            await updateCartCount();
        });
    </script>
</body>
</html>