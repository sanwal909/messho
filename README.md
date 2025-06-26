# Meesho E-commerce Clone

A pixel-perfect replica of the Meesho shopping platform with complete UPI payment integration.

## Features

✅ **Pixel-Perfect Design** - Exact replica matching Meesho screenshots
✅ **Responsive Layout** - Works on all devices (mobile, tablet, desktop)
✅ **UPI Deep Linking** - Redirects to actual UPI apps with payment amount
✅ **Similar Products** - Shows related items on product pages
✅ **Shopping Cart** - Full cart management with quantity controls
✅ **Multi-step Checkout** - Address, payment, and order confirmation
✅ **Admin Panel** - Easy way to add new products

## How to Add New Products

### Method 1: Admin Panel (Recommended)
1. Visit `/admin.php` in your browser
2. Fill out the product form with:
   - Product name
   - Category (kurtis, suits, combos, etc.)
   - Current price and original price
   - Rating and review count
   - Product image URL
   - Special offer text
3. Click "Add Product"

### Method 2: Direct JSON Editing
Edit `data/products.json` and add a new product object:

```json
{
  "id": 25,
  "name": "NEW PRODUCT NAME",
  "category": "kurtis",
  "price": 98,
  "originalPrice": 1949,
  "discount": 95,
  "rating": 4.5,
  "reviews": 1234,
  "image": "https://images.meesho.com/images/products/12345/abcde_512.webp",
  "offer": "₹675 with 2 Special Offers"
}
```

## Product Image URLs

For authentic Meesho look, use real Meesho image URLs:
- Format: `https://images.meesho.com/images/products/[PRODUCT_ID]/[IMAGE_ID]_512.webp`
- Examples from the current products:
  - `https://images.meesho.com/images/products/95391018/wohqy_512.webp`
  - `https://images.meesho.com/images/products/120831491/vu6oh_512.webp`
  - `https://images.meesho.com/images/products/95391020/wohax_512.webp`

## UPI Payment Integration

The checkout process includes real UPI deep linking:

### Supported UPI Apps:
- **Paytm** - `paytmmp://pay?pa=...`
- **PhonePe** - `phonepe://pay?pa=...`
- **Google Pay** - `tez://upi/pay?pa=...`
- **BharatPe** - `bharatpe://pay?pa=...`
- **BHIM UPI** - `bhim://pay?pa=...`

### UPI ID Configuration:
- Current UPI ID: `rekhadevi573710.rzp@icici`
- To change: Edit the `upiId` variable in `checkout.php` line 301

## File Structure

```
/
├── index.php           # Home page with product grid
├── product.php         # Product detail page with similar products
├── cart.php           # Shopping cart with progress tracking
├── checkout.php       # Multi-step checkout process
├── admin.php          # Admin panel for adding products
├── assets/
│   ├── css/
│   │   └── meesho-exact.css  # Main stylesheet with responsive design
│   └── js/
│       ├── main.js          # Core functionality
│       ├── cart.js          # Cart management
│       └── checkout.js      # Checkout and UPI integration
├── api/
│   ├── products.php    # Product data API
│   └── cart.php        # Cart management API
└── data/
    ├── products.json   # Product database
    └── states.json     # Indian states for checkout
```

## Responsive Breakpoints

- **Mobile**: 360px - 480px (2 columns)
- **Tablet**: 481px - 768px (3 columns)
- **Desktop**: 769px+ (4-5 columns)

## Categories

Available product categories:
- `kurtis` - Traditional Indian tops
- `suits` - Two-piece sets
- `combos` - Multi-piece sets
- `sarees` - Traditional Indian wear
- `dresses` - Western wear

## Technical Features

### UPI Deep Linking
When users select a UPI app and click "Pay Now":
1. Shows loading modal
2. Generates app-specific deep link with amount
3. Redirects to selected UPI app
4. Simulates payment completion
5. Clears cart and shows success

### Similar Products
Product detail pages automatically show 4 similar products from the same category, excluding the current product.

### Responsive Design
- Mobile-first approach
- Touch-friendly interface
- Optimized for all screen sizes
- Grid layouts adapt automatically

## Browser Support

- Chrome/Edge (recommended)
- Firefox
- Safari
- Mobile browsers (Android/iOS)

## Development

Built with vanilla PHP, HTML, CSS, and JavaScript. No frameworks required.

### Local Development
1. Start PHP server: `php -S 0.0.0.0:5000`
2. Visit `http://localhost:5000`
3. Admin panel: `http://localhost:5000/admin.php`

## License

Educational project - Meesho clone for demonstration purposes.