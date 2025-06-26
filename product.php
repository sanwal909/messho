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
            <div class="search-container">
                <input type="text" placeholder="Try Saree, Kurti or Search by Product Code" id="searchInput">
                <i class="fas fa-search search-icon"></i>
            </div>
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
            <div class="image-indicators">
                <div class="indicator active"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
                <div class="indicator"></div>
            </div>
            <div class="similar-products">
                <h4>Similar</h4>
                <div class="similar-item">
                    <img src="https://images.meesho.com/images/products/95391018/wohqy_512.webp" alt="Similar">
                </div>
            </div>
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

        function selectSize(element) {
            document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove('selected'));
            element.classList.add('selected');
            selectedSize = element.dataset.size;
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
                        document.getElementById('productImage').src = currentProduct.image;
                        document.getElementById('productName').textContent = currentProduct.name;
                        document.getElementById('currentPrice').textContent = `₹${currentProduct.price}`;
                        document.getElementById('originalPrice').textContent = `₹${currentProduct.originalPrice}`;
                        document.getElementById('discount').textContent = `${currentProduct.discount}% off`;
                        document.getElementById('rating').textContent = currentProduct.rating;
                        document.getElementById('reviews').textContent = `(${currentProduct.reviews} reviews)`;
                        document.getElementById('offerText').textContent = currentProduct.offer;
                        document.title = `${currentProduct.name} - Meesho`;
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