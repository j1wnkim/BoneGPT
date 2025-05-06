# Use PHP 8.2 image with FPM
FROM php:8.2-fpm

# Install system dependencies and Apache
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev \
    nodejs \
    npm \
    iputils-ping \
    apache2 \
    libapache2-mod-fcgid \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pdo_mysql

# Set the working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install

# Configure permissions for logs and SSL certificates
RUN mkdir -p /var/log/apache2 && \
    chmod -R 755 /var/log/apache2 && \
    chown -R www-data:www-data /var/log/apache2 && \
    chown -R www-data:www-data /etc/ssl/certs /etc/ssl/private

# Expose ports for HTTP and HTTPS
EXPOSE 80 443

# Enable necessary Apache modules
RUN a2enmod rewrite proxy_fcgi ssl headers

# Start Apache and PHP-FPM together
CMD service apache2 start && php-fpm
