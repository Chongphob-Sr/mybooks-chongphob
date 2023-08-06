# Dockerfile for building the PHP and Apache image
FROM php:7.4-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli

# Copy the project files into the container
COPY . /var/www/html/

# Set the working directory
WORKDIR /var/www/html

# Expose the Apache port
EXPOSE 80

# Start Apache server on container startup
CMD ["apache2-foreground"]
