<?php
session_start();

// Handle form submission
if ($_POST && isset($_POST['action'])) {
    $productsFile = 'data/products.json';
    $products = json_decode(file_get_contents($productsFile), true);
    
    if ($_POST['action'] === 'add') {
        // Find the highest ID and increment
        $maxId = 0;
        foreach ($products as $product) {
            if ($product['id'] > $maxId) {
                $maxId = $product['id'];
            }
        }
        
        $newProduct = [
            'id' => $maxId + 1,
            'name' => $_POST['name'],
            'category' => $_POST['category'],
            'price' => (int)$_POST['price'],
            'originalPrice' => (int)$_POST['originalPrice'],
            'discount' => round((($_POST['originalPrice'] - $_POST['price']) / $_POST['originalPrice']) * 100),
            'rating' => (float)$_POST['rating'],
            'reviews' => (int)$_POST['reviews'],
            'image' => $_POST['image'],
            'offer' => $_POST['offer']
        ];
        
        $products[] = $newProduct;
        file_put_contents($productsFile, json_encode($products, JSON_PRETTY_PRINT));
        $message = "Product added successfully!";
    }
}

// Load existing products
$products = json_decode(file_get_contents('data/products.json'), true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add Products</title>
    <link rel="stylesheet" href="assets/css/meesho-exact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .admin-container {
            max-width: 800px;
            margin: 80px auto 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .admin-header {
            text-align: center;
            margin-bottom: 30px;
            color: #e60965;
        }
        .form-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e8e8e8;
            border-radius: 8px;
        }
        .form-section h3 {
            margin-bottom: 20px;
            color: #333;
        }
        .admin-form .form-group {
            margin-bottom: 15px;
        }
        .admin-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #333;
        }
        .admin-form input, .admin-form select, .admin-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .admin-form textarea {
            height: 80px;
            resize: vertical;
        }
        .btn-primary {
            background: #e60965;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        .btn-primary:hover {
            background: #d5085a;
        }
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .product-list {
            margin-top: 30px;
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #e8e8e8;
        }
        .product-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }
        .product-details {
            flex: 1;
        }
        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .product-price {
            color: #e60965;
            font-weight: 600;
        }
        .form-row {
            display: flex;
            gap: 15px;
        }
        .form-row .form-group {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <button onclick="window.location.href='index.php'" class="back-btn">
                <i class="fas fa-arrow-left"></i>
            </button>
            <div class="logo">
                <span class="logo-text">meesho admin</span>
            </div>
        </div>
    </header>

    <div class="admin-container">
        <div class="admin-header">
            <h1><i class="fas fa-plus-circle"></i> Add New Product</h1>
            <p>Add new products to your Meesho store</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="success-message">
                <i class="fas fa-check-circle"></i> <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form-section">
            <h3><i class="fas fa-box"></i> Product Information</h3>
            <form method="POST" class="admin-form">
                <input type="hidden" name="action" value="add">
                
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required placeholder="e.g., Pink Floral Kurti">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="kurtis">Kurtis</option>
                            <option value="suits">Suits</option>
                            <option value="combos">Combos</option>
                            <option value="sarees">Sarees</option>
                            <option value="dresses">Dresses</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Current Price (₹)</label>
                        <input type="number" id="price" name="price" required min="1" placeholder="98">
                    </div>
                    
                    <div class="form-group">
                        <label for="originalPrice">Original Price (₹)</label>
                        <input type="number" id="originalPrice" name="originalPrice" required min="1" placeholder="1949">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="rating">Rating (1-5)</label>
                        <input type="number" id="rating" name="rating" required min="1" max="5" step="0.1" placeholder="4.5">
                    </div>
                    
                    <div class="form-group">
                        <label for="reviews">Number of Reviews</label>
                        <input type="number" id="reviews" name="reviews" required min="0" placeholder="1234">
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Product Image URL</label>
                    <input type="url" id="image" name="image" required placeholder="https://images.meesho.com/images/products/...">
                    <small style="color: #666; font-size: 12px;">
                        Use Meesho image URLs like: https://images.meesho.com/images/products/[product-id]/[image-id]_512.webp
                    </small>
                </div>

                <div class="form-group">
                    <label for="offer">Special Offer Text</label>
                    <input type="text" id="offer" name="offer" placeholder="₹675 with 2 Special Offers">
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </form>
        </div>

        <div class="form-section">
            <h3><i class="fas fa-list"></i> Existing Products (<?php echo count($products); ?>)</h3>
            <div class="product-list">
                <?php foreach (array_slice(array_reverse($products), 0, 10) as $product): ?>
                    <div class="product-item">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Product">
                        <div class="product-details">
                            <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                            <div class="product-price">₹<?php echo $product['price']; ?> <span style="text-decoration: line-through; color: #999;">₹<?php echo $product['originalPrice']; ?></span></div>
                        </div>
                        <div style="color: #666; font-size: 12px;">
                            ID: <?php echo $product['id']; ?> | <?php echo ucfirst($product['category']); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Auto-calculate discount
        document.getElementById('originalPrice').addEventListener('input', calculateDiscount);
        document.getElementById('price').addEventListener('input', calculateDiscount);
        
        function calculateDiscount() {
            const price = parseFloat(document.getElementById('price').value);
            const originalPrice = parseFloat(document.getElementById('originalPrice').value);
            
            if (price && originalPrice && originalPrice > price) {
                const discount = Math.round(((originalPrice - price) / originalPrice) * 100);
                console.log(`Discount: ${discount}%`);
            }
        }
    </script>
</body>
</html>