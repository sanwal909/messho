// Cart management functions

// Add product to cart
async function addProductToCart(product, size = 'M') {
    // Validate product data before sending
    if (!product || !product.id || !product.name || !product.price) {
        console.error('Invalid product data provided to addProductToCart:', product);
        return false;
    }
    
    try {
        const response = await fetch('api/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                productId: product.id,
                name: product.name,
                price: product.price,
                originalPrice: product.originalPrice || product.price,
                image: product.image || 'placeholder.jpg',
                size: size
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            updateCartCount();
            return true;
        } else {
            console.error('Error adding to cart:', result.error);
            return false;
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        return false;
    }
}

// Remove product from cart
async function removeProductFromCart(productId, size) {
    try {
        const response = await fetch('api/cart.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                productId: productId,
                size: size
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            updateCartCount();
            return true;
        } else {
            console.error('Error removing from cart:', result.error);
            return false;
        }
    } catch (error) {
        console.error('Error removing from cart:', error);
        return false;
    }
}

// Get cart contents
async function getCartContents() {
    try {
        const response = await fetch('api/cart.php');
        const cartData = await response.json();
        return cartData;
    } catch (error) {
        console.error('Error getting cart contents:', error);
        return { items: [], total: 0, count: 0 };
    }
}

// Update quantity in cart
async function updateCartQuantity(productId, size, quantity) {
    try {
        const response = await fetch('api/cart.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                productId: productId,
                size: size,
                quantity: quantity
            })
        });
        
        const result = await response.json();
        
        if (result.success) {
            updateCartCount();
            return true;
        } else {
            console.error('Error updating cart quantity:', result.error);
            return false;
        }
    } catch (error) {
        console.error('Error updating cart quantity:', error);
        return false;
    }
}

// Clear entire cart
async function clearCart() {
    try {
        // This would need a separate endpoint in a real implementation
        // For now, we'll work with the existing structure
        const cartData = await getCartContents();
        
        for (const item of cartData.items) {
            await removeProductFromCart(item.id, item.size);
        }
        
        updateCartCount();
        return true;
    } catch (error) {
        console.error('Error clearing cart:', error);
        return false;
    }
}

// Cart validation
function validateCartItem(product, size) {
    if (!product || !product.id) {
        console.error('Invalid product data');
        return false;
    }
    
    if (!size) {
        console.error('Size is required');
        return false;
    }
    
    const validSizes = ['S', 'M', 'L', 'XL', 'XXL'];
    if (!validSizes.includes(size)) {
        console.error('Invalid size');
        return false;
    }
    
    return true;
}

// Cart utility functions
function calculateCartTotal(items) {
    return items.reduce((total, item) => {
        return total + (item.price * item.quantity);
    }, 0);
}

function getCartItemCount(items) {
    return items.reduce((count, item) => {
        return count + item.quantity;
    }, 0);
}

// Local storage backup (fallback)
function saveCartToLocalStorage(cartData) {
    try {
        localStorage.setItem('meesho_cart_backup', JSON.stringify(cartData));
    } catch (error) {
        console.error('Error saving cart to local storage:', error);
    }
}

function getCartFromLocalStorage() {
    try {
        const cartData = localStorage.getItem('meesho_cart_backup');
        return cartData ? JSON.parse(cartData) : null;
    } catch (error) {
        console.error('Error getting cart from local storage:', error);
        return null;
    }
}

// Cart synchronization
async function syncCart() {
    try {
        const serverCart = await getCartContents();
        const localCart = getCartFromLocalStorage();
        
        if (localCart && localCart.items.length > 0 && serverCart.items.length === 0) {
            // Restore cart from local storage if server cart is empty
            for (const item of localCart.items) {
                await addProductToCart(item, item.size);
            }
        } else {
            // Save current server cart to local storage
            saveCartToLocalStorage(serverCart);
        }
        
        updateCartCount();
    } catch (error) {
        console.error('Error syncing cart:', error);
    }
}

// Initialize cart sync on page load
document.addEventListener('DOMContentLoaded', function() {
    syncCart();
});

// Export functions for global use
window.addProductToCart = addProductToCart;
window.removeProductFromCart = removeProductFromCart;
window.getCartContents = getCartContents;
window.updateCartQuantity = updateCartQuantity;
window.clearCart = clearCart;
