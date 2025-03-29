# Use the official PHP image with Apache
FROM php:7.4-apache

# Enable mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli

# Copy the CodeIgniter application to the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Copy custom PHP configuration
#COPY php.ini /usr/local/etc/php/

# Expose port 80 to the outside world
EXPOSE 80
