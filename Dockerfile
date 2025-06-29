# Use official PHP image with Apache
FROM php:8.1-apache

# Copy all project files into Apache web root
COPY . /var/www/html/

# Enable Apache mod_rewrite (agar zarurat ho)
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80
