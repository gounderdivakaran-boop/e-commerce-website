# Use official PHP-Apache image
FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Update Apache to listen on the port provided by Cloud Run ($PORT)
# Configure Apache to listen on the port provided by Cloud Run
RUN sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT}/' /etc/apache2/sites-available/000-default.conf

# Set production environment defaults
ENV PORT=8080
ENV APP_DEBUG=false

CMD ["sh", "-c", "apache2-foreground"]

# Copy your store files to the container
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set internal environment variable for Port (Fallback to 8080)
ENV PORT=8080
EXPOSE 8080

# Start Apache in the foreground
CMD ["apache2-foreground"]
