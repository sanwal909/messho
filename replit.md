# Meesho E-commerce Clone

## Overview

This is a PHP-based e-commerce web application that mimics the Meesho shopping platform. It's a multi-page shopping application with product browsing, cart management, and checkout functionality, built using vanilla PHP with session-based state management and JSON file storage for product data.

## System Architecture

### Frontend Architecture
- **Technology Stack**: HTML5, CSS3, vanilla JavaScript
- **UI Framework**: Custom CSS with FontAwesome icons
- **Responsive Design**: Mobile-first approach with responsive layouts
- **State Management**: Browser localStorage for address data, PHP sessions for cart

### Backend Architecture
- **Server Technology**: PHP 8.x with built-in development server
- **Architecture Pattern**: Simple MVC-like structure with API endpoints
- **Session Management**: PHP sessions for user state and cart persistence
- **Data Storage**: JSON files for static product data

### Key Pages Structure
- `index.php` - Main product listing page with categories and search
- `product.php` - Individual product detail view
- `cart.php` - Shopping cart management
- `checkout.php` - Multi-step checkout process (address, payment, summary)

## Key Components

### Product Management
- **Product Display**: Grid-based product listing with filtering and search
- **Product Categories**: Kurtis, suits, and other clothing categories
- **Product Details**: Individual product pages with image galleries and specifications

### Shopping Cart System
- **Cart Operations**: Add, remove, update quantity functionality
- **Session Persistence**: Cart data maintained across page navigation
- **Real-time Updates**: Dynamic cart count updates via AJAX

### Checkout Process
- **Multi-step Flow**: 4-step checkout (Cart → Address → Payment → Summary)
- **Address Management**: Form-based address collection with validation
- **Progress Tracking**: Visual progress indicators for checkout steps

### API Endpoints
- `api/products.php` - Product data retrieval with search/filter capabilities
- `api/cart.php` - RESTful cart management (GET, POST, DELETE operations)

## Data Flow

### Product Browsing Flow
1. User visits index.php
2. JavaScript loads products via `api/products.php`
3. Products filtered by category/search on client-side
4. Product grid dynamically updated

### Shopping Cart Flow
1. User adds product to cart via AJAX to `api/cart.php`
2. Cart data stored in PHP session
3. Cart count updated in header
4. Cart page displays session-stored items

### Checkout Flow
1. Cart → Address collection with validation
2. Address saved to localStorage
3. Payment method selection
4. Order summary and confirmation

## External Dependencies

### CDN Resources
- **FontAwesome 6.0.0**: Icons and UI elements
- **Pixabay Images**: Product image hosting

### Third-party Integrations
- Static JSON data files for products and Indian states
- No database or external API dependencies currently

## Deployment Strategy

### Development Environment
- **Platform**: Replit with PHP module
- **Server**: PHP built-in development server on port 5000
- **File Serving**: Direct file serving from project root

### Production Considerations
- Currently designed for development/demo purposes
- Would require database integration for production use
- Session storage suitable for single-server deployment only

### Scaling Requirements
- Database migration needed for product management
- User authentication system required
- Payment gateway integration needed for real transactions

## User Preferences

Preferred communication style: Simple, everyday language.

## Changelog

Changelog:
- June 26, 2025. Initial setup