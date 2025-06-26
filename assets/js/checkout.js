// Checkout process management

// Address validation
function validateAddress(addressData) {
    const required = ['fullName', 'mobile', 'pincode', 'city', 'state', 'houseNo', 'area'];
    
    for (const field of required) {
        if (!addressData[field] || addressData[field].trim() === '') {
            return { valid: false, field: field };
        }
    }
    
    // Validate mobile number
    if (!/^\d{10}$/.test(addressData.mobile.replace(/\D/g, ''))) {
        return { valid: false, field: 'mobile', message: 'Please enter a valid 10-digit mobile number' };
    }
    
    // Validate pincode
    if (!/^\d{6}$/.test(addressData.pincode)) {
        return { valid: false, field: 'pincode', message: 'Please enter a valid 6-digit pincode' };
    }
    
    return { valid: true };
}

// Save address
function saveAddress(addressData) {
    try {
        localStorage.setItem('meesho_delivery_address', JSON.stringify(addressData));
        return true;
    } catch (error) {
        console.error('Error saving address:', error);
        return false;
    }
}

// Get saved address
function getSavedAddress() {
    try {
        const addressData = localStorage.getItem('meesho_delivery_address');
        return addressData ? JSON.parse(addressData) : null;
    } catch (error) {
        console.error('Error getting saved address:', error);
        return null;
    }
}

// Load saved address into form
function loadSavedAddressToForm() {
    const savedAddress = getSavedAddress();
    if (!savedAddress) return;
    
    const fields = ['fullName', 'mobile', 'pincode', 'city', 'state', 'houseNo', 'area'];
    fields.forEach(field => {
        const element = document.getElementById(field);
        if (element && savedAddress[field]) {
            element.value = savedAddress[field];
        }
    });
}

// UPI payment integration
function generateUPILink(upiId, amount, note, paymentApp = 'upi') {
    const cleanAmount = amount.toString().replace('₹', '').replace(',', '');
    const encodedNote = encodeURIComponent(note);
    
    const baseParams = `pa=${upiId}&pn=Meesho&am=${cleanAmount}&cu=INR&tn=${encodedNote}`;
    
    const appUrls = {
        'gpay': `tez://upi/pay?${baseParams}`,
        'phonepe': `phonepe://pay?${baseParams}`,
        'paytm': `paytmmp://pay?${baseParams}`,
        'whatsapp': `whatsapp://pay?${baseParams}`,
        'upi': `upi://pay?${baseParams}`
    };
    
    return appUrls[paymentApp] || appUrls.upi;
}

// Process UPI payment
async function processUPIPayment(paymentMethod, amount) {
    const upiId = 'rekhadevi573710.rzp@icici';
    const orderNote = `Meesho Order - ${new Date().toISOString()}`;
    
    try {
        // Generate UPI deep link
        const upiLink = generateUPILink(upiId, amount, orderNote, paymentMethod);
        
        // Show loading state
        showPaymentLoading();
        
        // Attempt to open UPI app
        window.location.href = upiLink;
        
        // Fallback for web browsers that don't support app links
        setTimeout(() => {
            // Check if still on page (app didn't open)
            if (document.visibilityState === 'visible') {
                showUPIFallback(upiLink, upiId, amount);
            }
        }, 1000);
        
        // Simulate payment processing
        setTimeout(() => {
            hidePaymentLoading();
            // In a real app, you'd check payment status via webhook/API
            confirmPaymentSuccess();
        }, 3000);
        
    } catch (error) {
        console.error('Error processing UPI payment:', error);
        hidePaymentLoading();
        showPaymentError('Unable to process payment. Please try again.');
    }
}

// Show UPI fallback options
function showUPIFallback(upiLink, upiId, amount) {
    const fallbackModal = document.createElement('div');
    fallbackModal.className = 'upi-fallback-modal';
    fallbackModal.innerHTML = `
        <div class="modal-content">
            <h3>Complete Payment</h3>
            <p>Pay ₹${amount} to:</p>
            <div class="upi-id">${upiId}</div>
            <div class="fallback-options">
                <button onclick="copyUPIId('${upiId}')" class="copy-btn">
                    <i class="fas fa-copy"></i> Copy UPI ID
                </button>
                <button onclick="openUPIApp('${upiLink}')" class="open-app-btn">
                    <i class="fas fa-external-link-alt"></i> Open UPI App
                </button>
            </div>
            <button onclick="closeUPIFallback()" class="close-btn">Cancel</button>
        </div>
    `;
    
    document.body.appendChild(fallbackModal);
}

// Copy UPI ID to clipboard
function copyUPIId(upiId) {
    navigator.clipboard.writeText(upiId).then(() => {
        showNotification('UPI ID copied to clipboard', 'success');
    }).catch(() => {
        // Fallback for older browsers
        const textarea = document.createElement('textarea');
        textarea.value = upiId;
        document.body.appendChild(textarea);
        textarea.select();
        document.execCommand('copy');
        document.body.removeChild(textarea);
        showNotification('UPI ID copied to clipboard', 'success');
    });
}

// Open UPI app
function openUPIApp(upiLink) {
    window.location.href = upiLink;
}

// Close UPI fallback modal
function closeUPIFallback() {
    const modal = document.querySelector('.upi-fallback-modal');
    if (modal) {
        modal.remove();
    }
}

// Payment loading states
function showPaymentLoading() {
    const loadingOverlay = document.createElement('div');
    loadingOverlay.className = 'payment-loading-overlay';
    loadingOverlay.innerHTML = `
        <div class="loading-content">
            <i class="fas fa-spinner fa-spin"></i>
            <p>Processing payment...</p>
            <small>Please don't close this page</small>
        </div>
    `;
    document.body.appendChild(loadingOverlay);
}

function hidePaymentLoading() {
    const overlay = document.querySelector('.payment-loading-overlay');
    if (overlay) {
        overlay.remove();
    }
}

// Payment success confirmation
function confirmPaymentSuccess() {
    const successModal = document.createElement('div');
    successModal.className = 'payment-success-modal';
    successModal.innerHTML = `
        <div class="modal-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Payment Successful!</h3>
            <p>Your order has been placed successfully.</p>
            <button onclick="goToOrderSummary()" class="continue-btn">Continue</button>
        </div>
    `;
    document.body.appendChild(successModal);
}

// Payment error handling
function showPaymentError(message) {
    const errorModal = document.createElement('div');
    errorModal.className = 'payment-error-modal';
    errorModal.innerHTML = `
        <div class="modal-content">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3>Payment Failed</h3>
            <p>${message}</p>
            <button onclick="closePaymentError()" class="retry-btn">Try Again</button>
        </div>
    `;
    document.body.appendChild(errorModal);
}

function closePaymentError() {
    const modal = document.querySelector('.payment-error-modal');
    if (modal) {
        modal.remove();
    }
}

// Navigate to order summary
function goToOrderSummary() {
    window.location.href = 'checkout.php?step=summary';
}

// Order completion
async function completeOrder() {
    try {
        // In a real app, this would call an API to create the order
        const orderData = {
            items: await getCartContents(),
            address: getSavedAddress(),
            paymentMethod: document.querySelector('input[name="upi"]:checked').id,
            timestamp: new Date().toISOString(),
            orderId: 'ORD' + Date.now()
        };
        
        // Save order to local storage (in real app, save to database)
        localStorage.setItem('meesho_last_order', JSON.stringify(orderData));
        
        // Clear cart
        await clearCart();
        
        // Show success and redirect
        showNotification('Order placed successfully!', 'success');
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 2000);
        
    } catch (error) {
        console.error('Error completing order:', error);
        showPaymentError('Unable to complete order. Please try again.');
    }
}

// Form auto-save
function setupFormAutoSave() {
    const formInputs = document.querySelectorAll('#addressForm input, #addressForm select');
    formInputs.forEach(input => {
        input.addEventListener('blur', () => {
            const formData = new FormData(document.getElementById('addressForm'));
            const addressData = Object.fromEntries(formData);
            localStorage.setItem('meesho_temp_address', JSON.stringify(addressData));
        });
    });
}

// Load temporary address data
function loadTempAddressData() {
    try {
        const tempData = localStorage.getItem('meesho_temp_address');
        if (tempData) {
            const addressData = JSON.parse(tempData);
            Object.keys(addressData).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = addressData[key];
                }
            });
        }
    } catch (error) {
        console.error('Error loading temp address data:', error);
    }
}

// Initialize checkout
document.addEventListener('DOMContentLoaded', function() {
    // Load saved address if on address step
    if (document.getElementById('addressForm')) {
        loadSavedAddressToForm();
        loadTempAddressData();
        setupFormAutoSave();
    }
});

// Add CSS for modals and overlays
const checkoutStyles = `
<style>
.upi-fallback-modal,
.payment-loading-overlay,
.payment-success-modal,
.payment-error-modal {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}

.modal-content,
.loading-content {
    background: white;
    padding: 30px;
    border-radius: 12px;
    text-align: center;
    max-width: 400px;
    margin: 20px;
}

.upi-id {
    background: #f5f5f5;
    padding: 15px;
    border-radius: 8px;
    font-family: monospace;
    font-size: 16px;
    margin: 15px 0;
    word-break: break-all;
}

.fallback-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin: 20px 0;
}

.copy-btn,
.open-app-btn,
.close-btn,
.continue-btn,
.retry-btn {
    padding: 12px 24px;
    border: none;
    border-radius: 6px;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
}

.copy-btn {
    background: #FF1744;
    color: white;
}

.open-app-btn {
    background: #4CAF50;
    color: white;
}

.close-btn,
.retry-btn {
    background: #f5f5f5;
    color: #333;
}

.continue-btn {
    background: #FF1744;
    color: white;
}

.success-icon i {
    font-size: 60px;
    color: #4CAF50;
    margin-bottom: 20px;
}

.error-icon i {
    font-size: 60px;
    color: #E91E63;
    margin-bottom: 20px;
}

.loading-content i {
    font-size: 40px;
    color: #FF1744;
    margin-bottom: 20px;
}
</style>
`;

document.head.insertAdjacentHTML('beforeend', checkoutStyles);
