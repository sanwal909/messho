// Global variables
let products = [];
let filteredProducts = [];
let currentCategory = 'all';

// Initialize app
document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    updateCartCount();
    startTimer();
});

// Load products from API
async function loadProducts() {
    try {
        showLoading();
        const response = await fetch('api/products.php');
        products = await response.json();
        filteredProducts = [...products];
        displayProducts(filteredProducts);
        hideLoading();
    } catch (error) {
        console.error('Error loading products:', error);
        hideLoading();
    }
}

// Display products in grid
function displayProducts(productsToShow) {
    const grid = document.getElementById('productsGrid');
    if (!grid) return;

    if (productsToShow.length === 0) {
        grid.innerHTML = `
            <div class="no-products">
                <i class="fas fa-search"></i>
                <h3>No products found</h3>
                <p>Try adjusting your search or filters</p>
            </div>
        `;
        return;
    }

    grid.innerHTML = productsToShow.map(product => `
        <div class="product-card" onclick="viewProduct(${product.id})">
            <img src="${product.image}" alt="${product.name}" class="product-image">
            <div class="product-info">
                <h3 class="product-name">${product.name}</h3>
                <div class="product-price">
                    <span class="current-price">₹${product.price}</span>
                    <span class="original-price">₹${product.originalPrice}</span>
                    <span class="discount">${product.discount}% off</span>
                </div>
                <div class="special-offer-badge">₹${Math.floor(product.price * 0.25)} with 2 Special Offers</div>
                <div class="delivery-info">Free Delivery</div>
                <div class="product-rating">
                    <span class="rating-badge">
                        <i class="fas fa-star"></i>
                        ${product.rating}
                    </span>
                    <span class="rating-count">(${product.reviews})</span>
                    <span class="trusted-badge">
                        <i class="fas fa-shield-alt"></i>
                        Trusted
                    </span>
                </div>
                <div class="product-actions">
                    
                    </div>
            </div>
        </div>
    `).join('');
}

// Filter products by category
function filterCategory(category) {
    currentCategory = category;

    // Update active category
    document.querySelectorAll('.category-item').forEach(item => {
        item.classList.remove('active');
    });
    event.target.closest('.category-item').classList.add('active');

    // Filter products
    if (category === 'all') {
        filteredProducts = [...products];
    } else {
        filteredProducts = products.filter(product => product.category === category);
    }

    displayProducts(filteredProducts);
}

// Search products
function searchProducts() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();

    if (searchTerm === '') {
        filteredProducts = currentCategory === 'all' ? [...products] : products.filter(p => p.category === currentCategory);
    } else {
        const baseProducts = currentCategory === 'all' ? products : products.filter(p => p.category === currentCategory);
        filteredProducts = baseProducts.filter(product => 
            product.name.toLowerCase().includes(searchTerm) ||
            product.category.toLowerCase().includes(searchTerm)
        );
    }

    displayProducts(filteredProducts);
}

// Add search event listener
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', searchProducts);
    }
});

// View product details
function viewProduct(productId) {
    window.location.href = `product.php?id=${productId}`;
}

// Navigation functions
function navigateTo(page) {
    // Update active nav item
    document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
    });
    event.target.closest('.nav-item').classList.add('active');

    switch(page) {
        case 'home':
            window.location.href = 'index.php';
            break;
        case 'categories':
            // Scroll to categories section
            document.querySelector('.categories-section').scrollIntoView();
            break;
        case 'orders':
            alert('My Orders feature coming soon!');
            break;
        case 'help':
            alert('Help & Support feature coming soon!');
            break;
        case 'account':
            alert('Account section coming soon!');
            break;
    }
}

// Go to cart
function goToCart() {
    window.location.href = 'cart.php';
}

// Update cart count
async function updateCartCount() {
    try {
        const response = await fetch('api/cart.php');
        const cartData = await response.json();
        
        // Update all cart count elements
        const cartCounts = document.querySelectorAll('#cart-count, #cartCount, .cart-count');
        cartCounts.forEach(cartCount => {
            if (cartCount) {
                cartCount.textContent = cartData.count || 0;
                cartCount.style.display = cartData.count > 0 ? 'flex' : 'none';
            }
        });
    } catch (error) {
        console.error('Error updating cart count:', error);
    }
}

// Show notification
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Loading states
function showLoading() {
    const grid = document.getElementById('productsGrid');
    if (grid) {
        grid.innerHTML = `
            <div class="loading">
                <i class="fas fa-spinner"></i>
                <p>Loading products...</p>
            </div>
        `;
    }
}

function hideLoading() {
    // Loading will be replaced by products
}

// Timer for daily deals
function startTimer() {
    const timerElement = document.getElementById('timer');
    if (!timerElement) return;

    let hours = 1;
    let minutes = 10;
    let seconds = 24;

    setInterval(() => {
        seconds--;
        if (seconds < 0) {
            seconds = 59;
            minutes--;
            if (minutes < 0) {
                minutes = 59;
                hours--;
                if (hours < 0) {
                    hours = 23;
                }
            }
        }

        const h = hours.toString().padStart(2, '0');
        const m = minutes.toString().padStart(2, '0');
        const s = seconds.toString().padStart(2, '0');

        timerElement.textContent = `${h}h:${m}m:${s}s`;
    }, 1000);
}

// Menu toggle
function toggleMenu() {
    alert('Menu feature coming soon!');
}

// Utility functions
function formatPrice(price) {
    return `₹${price.toFixed(2)}`;
}

function calculateDiscount(original, current) {
    return Math.round(((original - current) / original) * 100);
}

// Add to cart function
async function addToCart(product, size = 'M') {
    if (event) {
        event.stopPropagation(); // Prevent product card click
    }
    
    // Validate product data
    if (!product || !product.id || !product.name || !product.price) {
        console.error('Invalid product data:', product);
        showNotification('Invalid product data', 'error');
        return;
    }
    
    try {
        const success = await addProductToCart(product, size);
        if (success) {
            showNotification('Product added to cart!', 'success');
        } else {
            showNotification('Failed to add product to cart', 'error');
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        showNotification('Error adding product to cart', 'error');
    }
}

// Error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
});

// Network status
window.addEventListener('online', function() {
    showNotification('Connection restored', 'success');
});

window.addEventListener('offline', function() {
    showNotification('No internet connection', 'error');
});