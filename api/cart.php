<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'PUT':
        // Update item quantity in cart
        $input = json_decode(file_get_contents('php://input'), true);
        
        if ($input && isset($input['productId']) && isset($input['size']) && isset($input['quantity'])) {
            $productId = $input['productId'];
            $size = $input['size'];
            $quantity = intval($input['quantity']);
            
            if ($quantity <= 0) {
                // Remove item if quantity is 0 or less
                $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId, $size) {
                    return !($item['id'] == $productId && $item['size'] == $size);
                });
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            } else {
                // Update quantity
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['id'] == $productId && $item['size'] == $size) {
                        $item['quantity'] = $quantity;
                        break;
                    }
                }
            }
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
        }
        break;
        
    case 'GET':
        // Get cart contents
        $cartItems = [];
        $total = 0;
        
        foreach ($_SESSION['cart'] as $item) {
            $cartItems[] = [
                'product' => [
                    'id' => $item['id'] ?? 0,
                    'name' => $item['name'] ?? 'Unknown Product',
                    'price' => $item['price'] ?? 0,
                    'originalPrice' => $item['originalPrice'] ?? 0,
                    'image' => $item['image'] ?? 'placeholder.jpg'
                ],
                'size' => $item['size'] ?? 'M',
                'quantity' => $item['quantity'] ?? 1
            ];
            $total += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        
        echo json_encode([
            'items' => $cartItems,
            'total' => $total,
            'count' => array_sum(array_column($_SESSION['cart'], 'quantity'))
        ]);
        break;
        
    case 'POST':
        // Add item to cart
        $input = json_decode(file_get_contents('php://input'), true);
        
        if ($input && isset($input['productId']) && isset($input['name']) && isset($input['price'])) {
            // Validate required fields
            if (empty($input['productId']) || empty($input['name']) || $input['price'] <= 0) {
                echo json_encode(['success' => false, 'error' => 'Invalid product data']);
                break;
            }
            
            $productId = $input['productId'];
            $size = $input['size'] ?? 'M';
            
            // Check if item already exists
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] == $productId && $item['size'] == $size) {
                    $item['quantity']++;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $input['productId'],
                    'name' => $input['name'],
                    'price' => $input['price'],
                    'originalPrice' => $input['originalPrice'] ?? $input['price'],
                    'image' => $input['image'] ?? 'placeholder.jpg',
                    'size' => $size,
                    'quantity' => 1
                ];
            }
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Missing required product data']);
        }
        break;
        
    case 'DELETE':
        // Remove item from cart
        $input = json_decode(file_get_contents('php://input'), true);
        
        if ($input) {
            $productId = $input['productId'];
            $size = $input['size'];
            
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($productId, $size) {
                return !($item['id'] == $productId && $item['size'] == $size);
            });
            
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid input']);
        }
        break;
        
    default:
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
