# Use official PHP image with Apache
FROM php:8.2-apache

# Enable PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into container
COPY . /var/www/html/

# Expose port 80
EXPOSE 80
