<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$productId = isset($_GET['id']) ? intval($_GET['id']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - Meesho</title>
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
            <!-- <div class="search-container">
                <input type="text" placeholder="Try Saree, Kurti or Search by Product Code" id="searchInput">
                <i class="fas fa-search search-icon"></i>
            </div> -->
            <div class="header-icons">
                <i class="fas fa-heart"></i>
                <div class="cart-icon" onclick="goToCart()">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count" id="cart-count">0</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Product Detail Container -->
    <div class="product-detail-container">
        <!-- Product Images -->
        <div class="product-images">
            <div class="main-image">
                <img id="productImage" src="" alt="Product Image">
            </div>
            <div class="image-indicators" id="imageIndicators">
                <!-- Indicators will be generated dynamically -->
            </div>
            <!-- <div class="similar-products">
                <h4>Similar</h4>
                <div class="similar-item">
                    <img src="data/imgi_213_2F508122-B184-4A92-B90A-4198FB3FD61E-scaled.jpg" alt="Similar">
                </div>
            </div> -->
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <div class="product-actions-top">
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i>
                    <span>Wishlist</span>
                </button>
                <button class="share-btn">
                    <i class="fas fa-share-alt"></i>
                    <span>Share</span>
                </button>
            </div>

            <h1 class="product-title" id="productName"></h1>
            
            <div class="product-pricing">
                <div class="price-section">
                    <span class="current-price" id="currentPrice"></span>
                    <span class="original-price" id="originalPrice"></span>
                    <span class="discount-percent" id="discount"></span>
                </div>
                <div class="offer-badge" id="offerText"></div>
            </div>

            <div class="rating-section">
                <div class="rating-badge">
                    <i class="fas fa-star"></i>
                    <span id="rating"></span>
                </div>
                <span class="review-count" id="reviews"></span>
                <div class="trusted-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Trusted</span>
                </div>
            </div>

            <div class="delivery-section">
                <div class="delivery-info">Free Delivery</div>
            </div>
        </div>

        <!-- Size Selection -->
        <div class="size-selection">
            <h3>Select Size</h3>
            <div class="size-options">
                <button class="size-option" onclick="selectSize(this)" data-size="S">S</button>
                <button class="size-option selected" onclick="selectSize(this)" data-size="M">M</button>
                <button class="size-option" onclick="selectSize(this)" data-size="L">L</button>
                <button class="size-option" onclick="selectSize(this)" data-size="XL">XL</button>
            </div>
        </div>

        <!-- Similar Products -->
        <div class="similar-products-section">
            <h3>Similar Products</h3>
            <div class="similar-products-grid" id="similarProducts">
                <!-- Similar products will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Product Actions -->
    <div class="product-actions">
        <button class="add-to-cart-btn" onclick="addToCart()">
            Add to Cart
        </button>
        <button class="buy-now-btn" onclick="buyNow()">
            Buy Now
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
        <div class="nav-item" onclick="goToCart()">
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
        let selectedSize = 'M';
        let currentProduct = null;
        let currentImageIndex = 0;
        let productImages = [];

        function selectSize(element) {
            document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('selected'));
            element.classList.add('selected');
            selectedSize = element.dataset.size;
        }

        function showImage(index) {
            if (productImages.length > 0) {
                currentImageIndex = index;
                document.getElementById('productImage').src = productImages[index];
                
                // Update indicators
                document.querySelectorAll('.indicator').forEach((ind, i) => {
                    ind.classList.toggle('active', i === index);
                });
            }
        }

        function createImageIndicators() {
            const indicatorContainer = document.getElementById('imageIndicators');
            indicatorContainer.innerHTML = '';
            
            productImages.forEach((image, index) => {
                const indicator = document.createElement('div');
                indicator.className = `indicator ${index === 0 ? 'active' : ''}`;
                indicator.onclick = () => showImage(index);
                indicatorContainer.appendChild(indicator);
            });
        }

        function nextImage() {
            if (productImages.length > 0) {
                currentImageIndex = (currentImageIndex + 1) % productImages.length;
                showImage(currentImageIndex);
            }
        }

        function previousImage() {
            if (productImages.length > 0) {
                currentImageIndex = (currentImageIndex - 1 + productImages.length) % productImages.length;
                showImage(currentImageIndex);
            }
        }

        // Touch swipe functionality
        let touchStartX = 0;
        let touchEndX = 0;
        let isSwiping = false;

        function handleTouchStart(e) {
            touchStartX = e.changedTouches[0].screenX;
            isSwiping = true;
        }

        function handleTouchMove(e) {
            if (!isSwiping) return;
            e.preventDefault(); // Prevent scrolling
        }

        function handleTouchEnd(e) {
            if (!isSwiping) return;
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
            isSwiping = false;
        }

        function handleSwipe() {
            const swipeThreshold = 50; // minimum swipe distance
            const swipeDistance = Math.abs(touchEndX - touchStartX);
            
            if (swipeDistance > swipeThreshold) {
                if (touchEndX < touchStartX) {
                    // Swipe left - next image
                    nextImage();
                } else if (touchEndX > touchStartX) {
                    // Swipe right - previous image
                    previousImage();
                }
            }
        }

        // Add touch event listeners to main image
        function setupTouchEvents() {
            const mainImage = document.querySelector('.main-image');
            if (mainImage) {
                // Remove existing listeners first
                mainImage.removeEventListener('touchstart', handleTouchStart);
                mainImage.removeEventListener('touchmove', handleTouchMove);
                mainImage.removeEventListener('touchend', handleTouchEnd);
                
                // Add new listeners
                mainImage.addEventListener('touchstart', handleTouchStart, { passive: false });
                mainImage.addEventListener('touchmove', handleTouchMove, { passive: false });
                mainImage.addEventListener('touchend', handleTouchEnd, { passive: false });
            }
        }

        async function addToCart() {
            if (!currentProduct) return;
            
            const result = await addProductToCart(currentProduct, selectedSize);
            if (result.success) {
                showNotification('Product added to cart!');
                updateCartCount();
            }
        }

        function buyNow() {
            addToCart();
            setTimeout(() => {
                window.location.href = 'cart.php';
            }, 500);
        }

        async function loadSimilarProducts() {
            try {
                const response = await fetch('api/products.php');
                const products = await response.json();
                
                // Get similar products (same category, excluding current product)
                const similarProducts = products
                    .filter(p => p.category === currentProduct.category && p.id !== currentProduct.id)
                    .slice(0, 4);
                
                const similarContainer = document.getElementById('similarProducts');
                similarContainer.innerHTML = '';
                
                similarProducts.forEach(product => {
                    const productHTML = `
                        <div class="similar-product-item" onclick="viewProduct(${product.id})">
                            <div class="similar-product-image">
                                <img src="${product.image}" alt="${product.name}">
                            </div>
                            <div class="similar-product-info">
                                <div class="similar-product-name">${product.name}</div>
                                <div class="similar-product-price">
                                    ₹${product.price}
                                    <span class="similar-product-original-price">₹${product.originalPrice}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    similarContainer.innerHTML += productHTML;
                });
            } catch (error) {
                console.error('Error loading similar products:', error);
            }
        }

        // Load product details on page load
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');
            
            if (productId) {
                try {
                    const response = await fetch('api/products.php');
                    const products = await response.json();
                    currentProduct = products.find(p => p.id == productId);
                    
                    if (currentProduct) {
                        // Set up product images
                        productImages = currentProduct.images || [currentProduct.image];
                        currentImageIndex = 0;
                        
                        // Display first image
                        document.getElementById('productImage').src = productImages[0];
                        
                        // Create image indicators
                        createImageIndicators();
                        
                        // Setup touch events for swipe
                        setupTouchEvents();
                        
                        // Set other product details
                        document.getElementById('productName').textContent = currentProduct.name;
                        document.getElementById('currentPrice').textContent = `₹${currentProduct.price}`;
                        document.getElementById('originalPrice').textContent = `₹${currentProduct.originalPrice}`;
                        document.getElementById('discount').textContent = `${currentProduct.discount}% off`;
                        document.getElementById('rating').textContent = currentProduct.rating;
                        document.getElementById('reviews').textContent = `(${currentProduct.reviews} reviews)`;
                        document.getElementById('offerText').textContent = currentProduct.offer;
                        document.title = `${currentProduct.name} - Meesho`;
                        
                        // Load similar products
                        await loadSimilarProducts();
                    }
                } catch (error) {
                    console.error('Error loading product:', error);
                }
            }
            
            updateCartCount();
        });
    </script>
</body>
</html>