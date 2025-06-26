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
            <div class="header-left">
                <button class="back-btn" onclick="goBack()">
                    <i class="fas fa-arrow-left"></i>
                </button>
                <div class="logo">
                    <span class="logo-text">meesho</span>
                </div>
            </div>
            <div class="header-right">
                <i class="far fa-heart wishlist-icon"></i>
                <div class="cart-icon" onclick="goToCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Product Details -->
    <div class="product-detail-container">
        <div class="product-images">
            <div class="main-image" id="mainImage">
                <!-- Main product image -->
            </div>
            <div class="image-indicators">
                <div class="indicator active"></div>
            </div>
            <div class="similar-products">
                <h4>1 Similar Products</h4>
                <div class="similar-item" id="similarProduct">
                    <!-- Similar product thumbnail -->
                </div>
            </div>
        </div>

        <div class="product-info">
            <h2 class="product-title" id="productTitle">PINK FRILL KNEE LENGTH DRESS</h2>
            
            <div class="product-actions-top">
                <div class="wishlist-btn">
                    <i class="far fa-heart"></i>
                    <span>Wishlist</span>
                </div>
                <div class="share-btn">
                    <i class="fas fa-share-alt"></i>
                    <span>Share</span>
                </div>
            </div>
            
            <div class="product-pricing">
                <div class="price-section">
                    <span class="current-price" id="currentPrice">₹98.00</span>
                    <span class="original-price" id="originalPrice">₹1949</span>
                    <span class="discount-percent" id="discountPercent">95% off</span>
                </div>
                <div class="special-offers">
                    <div class="offer-badge">₹675 with 2 Special Offers</div>
                </div>
            </div>
            
            <div class="rating-section">
                <div class="rating-badge">
                    <i class="fas fa-star"></i>
                    <span id="productRating">4.5</span>
                </div>
                <span class="review-count" id="reviewCount">784 ratings and 61 reviews</span>
                <div class="trusted-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Trusted</span>
                </div>
            </div>
            
            <div class="delivery-section">
                <div class="delivery-info">Free Delivery</div>
            </div>
            
            <div class="product-actions">
                <button class="wishlist-btn">
                    <i class="far fa-heart"></i>
                    <span>Wishlist</span>
                </button>
                <button class="share-btn">
                    <i class="fas fa-share-alt"></i>
                    <span>Share</span>
                </button>
            </div>

            <div class="price-section">
                <span class="current-price" id="currentPrice">₹98.00</span>
                <span class="original-price" id="originalPrice">₹1949.00</span>
                <span class="discount" id="discount">95% off</span>
            </div>

            <div class="offers">
                <div class="offer-tag">
                    <i class="fas fa-tag"></i>
                    <span id="offerText">₹675 with 2 Special Offers</span>
                </div>
            </div>

            <div class="rating-section">
                <div class="rating">
                    <span class="rating-score">4.3</span>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <span class="rating-count">784 ratings and 61 reviews</span>
                </div>
                <div class="trusted-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Trusted</span>
                </div>
            </div>

            <div class="delivery-info">
                <i class="fas fa-truck"></i>
                <span>Free Delivery</span>
            </div>

            <div class="size-section">
                <h3>Select Size</h3>
                <div class="size-options">
                    <button class="size-btn" onclick="selectSize('S')">S</button>
                    <button class="size-btn active" onclick="selectSize('M')">M</button>
                    <button class="size-btn" onclick="selectSize('L')">L</button>
                    <button class="size-btn" onclick="selectSize('XL')">XL</button>
                    <button class="size-btn" onclick="selectSize('XXL')">XXL</button>
                </div>
            </div>

            <div class="product-details">
                <h3>Product Details</h3>
                <p>Feeling cute? Here's the best outfit to satisfy your cuteness! This cute, chic dress with frills on the verge and sleeves will help you feeling flow cut just right!</p>
                
                <div class="detail-item">
                    <strong>Model is Wearing:</strong> S Size
                </div>
                <div class="detail-item">
                    <strong>Model Height:</strong> 5.5
                </div>
                <div class="detail-item">
                    <strong>Care:</strong> Dry Clean / Easy Wash
                </div>
                <div class="detail-item">
                    <strong>Shipping Info:</strong> 15 to 17 Days
                </div>

                <div class="dress-details">
                    <h4>Dress :</h4>
                    <ul>
                        <li>Fabric - cotton glace</li>
                        <li>Fully Flared</li>
                        <li>Length - 45"</li>
                        <li>Sleeves - 15"</li>
                        <li>side zip</li>
                    </ul>
                </div>
            </div>

            <div class="recommendations">
                <h3>Products For You</h3>
                <div class="recommendation-grid" id="recommendationGrid">
                    <!-- Recommended products will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <button class="add-to-cart-btn" onclick="addToCart()">
            <i class="fas fa-shopping-cart"></i>
            Add to Cart
        </button>
        <button class="buy-now-btn" onclick="buyNow()">
            <i class="fas fa-bolt"></i>
            Buy Now
        </button>
    </div>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
    <script>
        let currentProduct = null;
        let selectedSize = 'M';

        // Load product details
        async function loadProductDetails() {
            try {
                const response = await fetch('api/products.php');
                const products = await response.json();
                currentProduct = products.find(p => p.id === <?php echo $productId; ?>) || products[0];
                
                displayProduct(currentProduct);
                loadRecommendations(products);
                updateCartCount();
            } catch (error) {
                console.error('Error loading product:', error);
            }
        }

        function displayProduct(product) {
            document.getElementById('mainImage').innerHTML = `<img src="${product.image}" alt="${product.name}">`;
            document.getElementById('productTitle').textContent = product.name;
            document.getElementById('currentPrice').textContent = `₹${product.price}`;
            document.getElementById('originalPrice').textContent = `₹${product.originalPrice}`;
            document.getElementById('discount').textContent = `${product.discount}% off`;
            document.getElementById('offerText').textContent = product.offer;
            
            document.getElementById('similarProduct').innerHTML = `<img src="${product.image}" alt="${product.name}">`;
        }

        function loadRecommendations(products) {
            const grid = document.getElementById('recommendationGrid');
            const recommendations = products.slice(0, 6);
            
            grid.innerHTML = recommendations.map(product => `
                <div class="recommendation-item" onclick="viewProduct(${product.id})">
                    <img src="${product.image}" alt="${product.name}">
                </div>
            `).join('');
        }

        function selectSize(size) {
            selectedSize = size;
            document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
        }

        function addToCart() {
            if (currentProduct) {
                addProductToCart(currentProduct, selectedSize);
                showNotification('Added to cart!');
            }
        }

        function buyNow() {
            if (currentProduct) {
                addProductToCart(currentProduct, selectedSize);
                window.location.href = 'cart.php';
            }
        }

        function goBack() {
            window.history.back() || (window.location.href = 'index.php');
        }

        function viewProduct(id) {
            window.location.href = `product.php?id=${id}`;
        }

        // Initialize
        loadProductDetails();
    </script>
</body>
</html>
