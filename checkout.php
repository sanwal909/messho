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

            <!-- QR Code Payment Option -->
            <div class="payment-method">
                <div class="method-header" onclick="togglePaymentMethod('qr')">
                    <span class="method-title">Pay with QR Code</span>
                    <span class="method-subtitle">Scan & Pay - Auto amount filled</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="qr-payment-section" id="qrPaymentSection" style="display: none;">
                    <div class="qr-code-container">
                        <div id="qrCodeDisplay" class="qr-code-display">
                            <div class="qr-loading">
                                <i class="fas fa-spinner fa-spin"></i>
                                <p>Generating QR Code...</p>
                            </div>
                        </div>
                        <div class="qr-payment-info">
                            <h4>Scan QR with any UPI app</h4>
                            <p class="payment-amount">₹<span id="qrAmount">0</span></p>
                            <div class="upi-apps-list">
                                <img src="imgi_2_gpay_icon.png" alt="Google Pay" title="Google Pay">
                                <img src="imgi_3_phonepe.png" alt="PhonePe" title="PhonePe">
                                <img src="paytm.jpg" alt="Paytm" title="Paytm">
                                <img src="bharat.jpeg" alt="BharatPe" title="BharatPe">
                                <img src="bhim.png" alt="BHIM" title="BHIM">
                            </div>
                            <p class="qr-instructions">
                                1. Open any UPI app<br>
                                2. Scan the QR code<br>
                                3. Amount will be auto-filled<br>
                                4. Enter UPI PIN to pay
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-method">
                <div class="method-header" onclick="togglePaymentMethod('upi')">
                    <span class="method-title">UPI Apps</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="upi-options" id="upiOptions">
  <div class="upi-option">
    <input type="radio" id="paytm" name="upiMethod" value="paytm">
    <label for="paytm">
      <span class="upi-label-text">Paytm</span>
      <div class="upi-app-icon paytm">
        <img src="paytm.jpg" alt="Paytm">
      </div>
    </label>
  </div>

  <div class="upi-option">
    <input type="radio" id="phonepe" name="upiMethod" value="phonepe">
    <label for="phonepe">
      <span class="upi-label-text">PhonePe</span>
      <div class="upi-app-icon phonepe">
        <img src="imgi_3_phonepe.png" alt="PhonePe">
      </div>
    </label>
  </div>

  <div class="upi-option">
    <input type="radio" id="googlepay" name="upiMethod" value="googlepay" checked>
    <label for="googlepay">
      <span class="upi-label-text">Google Pay</span>
      <div class="upi-app-icon googlepay">
        <img src="imgi_2_gpay_icon.png" alt="Google Pay">
      </div>
    </label>
  </div>

  <div class="upi-option">
    <input type="radio" id="bharatpe" name="upiMethod" value="bharatpe">
    <label for="bharatpe">
      <span class="upi-label-text">BharatPe</span>
      <div class="upi-app-icon bharatpe">
        <img src="bharat.jpeg" alt="BharatPe">
      </div>
    </label>
  </div>

  <div class="upi-option">
    <input type="radio" id="bhim" name="upiMethod" value="bhim">
    <label for="bhim">
      <span class="upi-label-text">BHIM UPI</span>
      <div class="upi-app-icon bhim">
        <img src="bhim.png" alt="BHIM">
      </div>
    </label>
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
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/checkout.js"></script>
    <script>
        function togglePaymentMethod(method) {
            if (method === 'upi') {
                const upiOptions = document.getElementById('upiOptions');
                upiOptions.style.display = upiOptions.style.display === 'none' ? 'block' : 'none';
            } else if (method === 'qr') {
                const qrSection = document.getElementById('qrPaymentSection');
                if (qrSection.style.display === 'none' || qrSection.style.display === '') {
                    qrSection.style.display = 'block';
                    generateQRCode();
                } else {
                    qrSection.style.display = 'none';
                }
            }
        }

        async function generateQRCode() {
            try {
                const cartData = await getCartContents();
                const amount = cartData.total;
                
                document.getElementById('qrAmount').textContent = amount;
                
                // UPI QR code URL format
                const upiId = 'rekhadevi573710.rzp@icici';
                const merchantName = 'Meesho';
                const note = 'Meesho Order Payment';
                
                const upiString = `upi://pay?pa=${upiId}&pn=${encodeURIComponent(merchantName)}&am=${amount}&cu=INR&tn=${encodeURIComponent(note)}`;
                
                // Generate QR code using qr-server.com API
                const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(upiString)}`;
                
                const qrDisplay = document.getElementById('qrCodeDisplay');
                qrDisplay.innerHTML = `
                    <img src="${qrCodeUrl}" alt="UPI QR Code" class="qr-code-image">
                    <p class="qr-code-text">Scan to pay ₹${amount}</p>
                `;
                
            } catch (error) {
                console.error('Error generating QR code:', error);
                document.getElementById('qrCodeDisplay').innerHTML = `
                    <div class="qr-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <p>Unable to generate QR code</p>
                        <button onclick="generateQRCode()" class="retry-qr-btn">Try Again</button>
                    </div>
                `;
            }
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
                const paymentApp = selectedUPI.value;
                
                console.log('Selected UPI App:', paymentApp);
                console.log('Cart Total:', amount);
                
                // Use the checkout.js function
                await processUPIPayment(paymentApp, amount);
                
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
