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
    <title>Meesho - Online Shopping for Women Dresses, Kurtis & More</title>
    <link rel="stylesheet" href="assets/css/meesho-exact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-left">
                <button class="menu-btn" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
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

    <!-- Search Bar -->
    <!-- <div class="search-container">
        <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" placeholder="Search for Sarees, Kurtis, Cosmetics, etc." id="searchInput">
        </div>
    </div> -->

    <!-- Categories -->
    <div class="categories-section">
        <div class="category-item active" onclick="filterCategory('all')">
            <div class="category-icon">
                <img src="cat.webp" alt="All Categories">"
                <div class="category-grid">
                    <div class="grid-item pink"></div>
                    <div class="grid-item orange"></div>
                    <div class="grid-item blue"></div>
                    <div class="grid-item yellow"></div>
                </div>
            </div>
            <span>Categories</span>
        </div>
        <div class="category-item" onclick="filterCategory('kurtis')">
            <div class="category-icon">
                <img src="data/imgi_239_8653FCFC-180B-4258-BA57-69AC7E0C11E1-scaled.jpg" alt="Kurtis">
            </div>
            <span>Kurtis</span>
        </div>
        <div class="category-item" onclick="filterCategory('suits')">
            <div class="category-icon">
                <img src="data/imgi_343_EB2CF48E-5E72-4449-A136-1EC8465A57BA-scaled.jpg" alt="Kurti 2 Com">
            </div>
            <span>Kurti 2 Com..</span>
        </div>
        <div class="category-item" onclick="filterCategory('combos')">
            <div class="category-icon">
                <img src="data/imgi_248_0726CEAD-BE5C-493A-B4A5-5CDD282F99C4-scaled4372.jpg" alt="Kurti 3 Com">
            </div>
            <span>Kurti 3 Com..</span>
        </div>
    </div>

    <!-- Banner -->
    <div class="banner-section">
        <!-- <div class="sale-banner">
            <div class="sale-text">
                <span class="biggest-brands">BIGGEST BRANDS BASH</span>
                <span class="live-sale">SALE IS LIVE</span>
            </div>
        </div>
        
        <div class="special-offer">
            <div class="offer-content">
                <h3>Wear With Pride</h3>
                <p>Perfect Kurtis for</p>
                <h4>Republic Day Special</h4>
                <button class="shop-now-btn">Shop Now</button>
                <div class="offer-details">
                    <span>₹100 on orders above ₹799</span>
                </div>
            </div>
        </div> -->
        <img src="1706108173253_600.webp" alt="Banner Image">
    </div>

    <!-- Features -->
    <div class="features-section">
        <div class="feature-item">
            <i class="fas fa-undo"></i>
            <div>
                <strong>Easy returns</strong>
                <span>& refunds</span>
            </div>
        </div>
        <div class="feature-item">
            <i class="fas fa-money-bill-wave"></i>
            <div>
                <strong>Cash on</strong>
                <span>delivery</span>
            </div>
        </div>
        <div class="feature-item">
            <i class="fas fa-tag"></i>
            <div>
                <strong>Lowest</strong>
                <span>prices</span>
            </div>
        </div>
    </div>

    <!-- Daily Deals -->
    <div class="deals-section">
        <div class="deals-header">
            <h3>Meesho Daily Deals ⚡</h3>
            <div class="timer">
                <i class="fas fa-clock"></i>
                <span id="timer">50m:24s</span>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="products-container">
        <div class="products-grid" id="productsGrid">
            <!-- Products will be loaded here -->
        </div>
    </div>

    <!-- Bottom Navigation -->
    <nav class="bottom-nav">
        <div class="nav-item active" onclick="navigateTo('home')">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </div>
        <div class="nav-item" onclick="navigateTo('categories')">
            <i class="fas fa-th-large"></i>
            <span>Categories</span>
        </div>
        <div class="nav-item" onclick="navigateTo('orders')">
            <i class="fas fa-box"></i>
            <span>My Orders</span>
        </div>
        <div class="nav-item" onclick="navigateTo('help')">
            <i class="fas fa-question-circle"></i>
            <span>Help</span>
        </div>
        <div class="nav-item" onclick="navigateTo('account')">
            <i class="fas fa-user"></i>
            <span>Account</span>
        </div>
    </nav>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
</body>
</html>
