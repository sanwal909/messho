<?php
header('Content-Type: application/json');

// Load products from JSON file
$productsJson = file_get_contents('../data/products.json');
$products = json_decode($productsJson, true);

// Handle search and filtering
$search = isset($_GET['search']) ? strtolower($_GET['search']) : '';
$category = isset($_GET['category']) ? $_GET['category'] : 'all';

if ($search || $category !== 'all') {
    $products = array_filter($products, function($product) use ($search, $category) {
        $matchesSearch = empty($search) || 
                        strpos(strtolower($product['name']), $search) !== false ||
                        strpos(strtolower($product['category']), $search) !== false;
        
        $matchesCategory = $category === 'all' || $product['category'] === $category;
        
        return $matchesSearch && $matchesCategory;
    });
}

echo json_encode(array_values($products));
?>
