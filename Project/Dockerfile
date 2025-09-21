# Use the official PHP image with Apache as the base image
FROM php:8.2-apache

# Install required extensions and libraries
RUN apt-get update && apt-get install -y \
    unzip \
    libzip-dev \
    # Add other necessary PHP extensions and OS packages here
    && docker-php-ext-install pdo pdo_mysql zip

# Set the working directory to the web root
WORKDIR /var/www/html

# Copy composer files before copying the entire project to leverage Docker's build cache
COPY composer.json composer.lock ./

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of your application files
COPY . .

# Expose the web server port
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
