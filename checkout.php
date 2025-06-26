<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$step = isset($_GET['step']) ? $_GET['step'] : 'address';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Meesho</title>
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

    <!-- Checkout Container -->
    <div class="checkout-container">
        <!-- Checkout Progress -->
        <div class="checkout-progress">
            <div class="progress-steps">
                <div class="progress-step">
                    <div class="step-number completed">1</div>
                    <div class="step-label">Cart</div>
                </div>
                <div class="progress-step">
                    <div class="step-number <?php echo $step === 'address' ? 'active' : ($step === 'payment' || $step === 'summary' ? 'completed' : ''); ?>">2</div>
                    <div class="step-label <?php echo $step === 'address' ? 'active' : ''; ?>">Address</div>
                </div>
                <div class="progress-step">
                    <div class="step-number <?php echo $step === 'payment' ? 'active' : ($step === 'summary' ? 'completed' : ''); ?>">3</div>
                    <div class="step-label <?php echo $step === 'payment' ? 'active' : ''; ?>">Payment</div>
                </div>
                <div class="progress-step">
                    <div class="step-number <?php echo $step === 'summary' ? 'active' : ''; ?>">4</div>
                    <div class="step-label <?php echo $step === 'summary' ? 'active' : ''; ?>">Summary</div>
                </div>
            </div>
        </div>

        <?php if ($step === 'address'): ?>
        <!-- Address Form -->
        <div class="address-form">
            <div class="section-header">
                <i class="fas fa-map-marker-alt"></i>
                <h3>Delivery Address</h3>
            </div>
            <form id="addressForm">
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" required>
                </div>
                
                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
                
                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" id="pincode" name="pincode" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="state">State</label>
                        <select id="state" name="state" required>
                            <option value="">Select State</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="address">House No., Building Name</label>
                    <input type="text" id="address" name="address" required>
                </div>
                
                <div class="form-group">
                    <label for="area">Road name, Area, Colony</label>
                    <input type="text" id="area" name="area" required>
                </div>
                
                <button type="submit" class="save-address-btn">Save Address & Continue</button>
            </form>
        </div>
        <?php endif; ?>

        <?php if ($step === 'payment'): ?>
        <!-- Payment Methods -->
        <div class="payment-methods">
            <div class="section-header">
                <i class="fas fa-credit-card"></i>
                <h3>Payment Method</h3>
            </div>
            
            <div class="payment-offer">
                <i class="fas fa-gift"></i>
                <span>Get ₹50 cashback on your first UPI payment</span>
            </div>

            <div class="payment-method">
                <div class="method-header" onclick="togglePaymentMethod('upi')">
                    <span class="method-title">UPI</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="upi-options" id="upiOptions">
                    <div class="upi-option">
                        <input type="radio" id="paytm" name="upiMethod" value="paytm">
                        <label for="paytm">
                            <div class="upi-app-icon paytm">P</div>
                            <span>Paytm</span>
                        </label>
                    </div>
                    <div class="upi-option">
                        <input type="radio" id="phonepe" name="upiMethod" value="phonepe">
                        <label for="phonepe">
                            <div class="upi-app-icon phonepe">Pe</div>
                            <span>PhonePe</span>
                        </label>
                    </div>
                    <div class="upi-option">
                        <input type="radio" id="googlepay" name="upiMethod" value="googlepay">
                        <label for="googlepay">
                            <div class="upi-app-icon googlepay">G</div>
                            <span>Google Pay</span>
                        </label>
                    </div>
                    <div class="upi-option">
                        <input type="radio" id="bharatpe" name="upiMethod" value="bharatpe" checked>
                        <label for="bharatpe">
                            <div class="upi-app-icon bharatpe">B</div>
                            <span>BharatPe</span>
                        </label>
                    </div>
                    <div class="upi-option">
                        <input type="radio" id="bhim" name="upiMethod" value="bhim">
                        <label for="bhim">
                            <div class="upi-app-icon bhim">UPI</div>
                            <span>BHIM UPI</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="payment-method">
                <div class="method-header">
                    <span class="method-title">Cash on Delivery</span>
                </div>
            </div>
        </div>
        
        <button class="pay-now-btn" onclick="processPayment()">
            Pay Now
        </button>
        <?php endif; ?>

        <?php if ($step === 'summary'): ?>
        <!-- Order Summary -->
        <div class="order-summary">
            <div class="section-header">
                <i class="fas fa-check-circle"></i>
                <h3>Order Placed Successfully!</h3>
            </div>
            <div class="success-message">
                <p>Your order has been confirmed and will be delivered soon.</p>
                <p>Order ID: #MSH<?php echo rand(100000, 999999); ?></p>
            </div>
        </div>
        <?php endif; ?>
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
        <div class="nav-item" onclick="goToCart()">
            <i class="fas fa-shopping-bag"></i>
            <span>Cart</span>
        </div>
        <div class="nav-item">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </div>
    </nav>

    <!-- Payment Modal -->
    <div class="payment-modal" id="paymentModal">
        <div class="payment-modal-content">
            <div class="payment-loading" id="paymentLoading">
                <div class="payment-spinner"></div>
                <h3>Redirecting to Payment App</h3>
                <p>Please complete the payment in your UPI app</p>
            </div>
            <div class="payment-success" id="paymentSuccess" style="display: none;">
                <i class="fas fa-check-circle" style="color: #4caf50; font-size: 48px; margin-bottom: 16px;"></i>
                <h3>Payment Successful!</h3>
                <p>Your order has been placed successfully</p>
                <button onclick="confirmPaymentSuccess()">Continue</button>
            </div>
            <div class="payment-error" id="paymentError" style="display: none;">
                <i class="fas fa-times-circle" style="color: #f44336; font-size: 48px; margin-bottom: 16px;"></i>
                <h3>Payment Failed</h3>
                <p id="errorMessage">Something went wrong. Please try again.</p>
                <button onclick="closePaymentModal()">Try Again</button>
                <button class="secondary-btn" onclick="closePaymentModal()">Cancel</button>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/checkout.js"></script>
    <script>
        function togglePaymentMethod(method) {
            const upiOptions = document.getElementById('upiOptions');
            upiOptions.style.display = upiOptions.style.display === 'none' ? 'block' : 'none';
        }

        function showPaymentModal() {
            document.getElementById('paymentModal').style.display = 'flex';
            document.getElementById('paymentLoading').style.display = 'block';
            document.getElementById('paymentSuccess').style.display = 'none';
            document.getElementById('paymentError').style.display = 'none';
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').style.display = 'none';
        }

        function showPaymentSuccess() {
            document.getElementById('paymentLoading').style.display = 'none';
            document.getElementById('paymentSuccess').style.display = 'block';
        }

        function showPaymentError(message) {
            document.getElementById('paymentLoading').style.display = 'none';
            document.getElementById('paymentError').style.display = 'block';
            document.getElementById('errorMessage').textContent = message;
        }

        function confirmPaymentSuccess() {
            clearCart();
            window.location.href = 'checkout.php?step=summary';
        }

        function generateUPILink(upiId, amount, note, paymentApp) {
            const baseUrl = `upi://pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`;
            
            // App-specific deep links
            const appLinks = {
                'paytm': `paytmmp://pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`,
                'phonepe': `phonepe://pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`,
                'googlepay': `tez://upi/pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`,
                'bharatpe': `bharatpe://pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`,
                'bhim': `bhim://pay?pa=${upiId}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`
            };
            
            return appLinks[paymentApp] || baseUrl;
        }

        async function processPayment() {
            const selectedUPI = document.querySelector('input[name="upiMethod"]:checked');
            if (!selectedUPI) {
                alert('Please select a payment method');
                return;
            }

            try {
                const cartData = await getCartContents();
                const amount = cartData.total;
                const upiId = "rekhadevi573710.rzp@icici";
                const paymentApp = selectedUPI.value;
                const note = `Meesho Order Payment - ₹${amount}`;
                
                showPaymentModal();
                
                // Generate UPI deep link
                const upiLink = generateUPILink(upiId, amount, note, paymentApp);
                
                // Try to open the UPI app
                setTimeout(() => {
                    try {
                        window.location.href = upiLink;
                        
                        // Show success after 3 seconds (simulating payment completion)
                        setTimeout(() => {
                            showPaymentSuccess();
                        }, 3000);
                        
                    } catch (error) {
                        showPaymentError('Could not open payment app. Please try again.');
                    }
                }, 1000);
                
            } catch (error) {
                console.error('Payment error:', error);
                showPaymentError('Payment failed. Please try again.');
            }
        }

        // Load states data
        document.addEventListener('DOMContentLoaded', async () => {
            const step = new URLSearchParams(window.location.search).get('step') || 'address';
            
            if (step === 'address') {
                try {
                    const response = await fetch('data/states.json');
                    const states = await response.json();
                    const stateSelect = document.getElementById('state');
                    
                    states.forEach(state => {
                        const option = document.createElement('option');
                        option.value = state;
                        option.textContent = state;
                        stateSelect.appendChild(option);
                    });
                    
                    loadSavedAddressToForm();
                    setupFormAutoSave();
                } catch (error) {
                    console.error('Error loading states:', error);
                }

                // Handle address form submission
                document.getElementById('addressForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    const formData = new FormData(e.target);
                    const addressData = Object.fromEntries(formData);
                    
                    if (validateAddress(addressData)) {
                        saveAddress(addressData);
                        window.location.href = 'checkout.php?step=payment';
                    }
                });
            }
            
            await updateCartCount();
        });
    </script>
</body>
</html>