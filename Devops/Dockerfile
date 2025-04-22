FROM php:8.3-fpm-bookworm

# Install required system packages
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    ca-certificates \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Create Drupal project
RUN composer create-project drupal/recommended-project drupal-website --no-install

# Copy project files
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Set document root to /var/www/html/drupal-website/web
RUN sed -i "s|root /var/www/html;|root /var/www/html/drupal-website/web;|g" /etc/nginx/conf.d/default.conf

# Copy drupal-website to /var/www/html
RUN cp -r /var/www/html/drupal-website/. /var/www/html/

# Remove the original drupal-website directory
RUN rm -rf /var/www/html/drupal-website

# Change ownership for web server user
RUN chown -R www-data:www-data /var/www/html

# Install Drupal dependencies
RUN composer install

# Copy default.settings.php to settings.php
WORKDIR /var/www/html/web/sites/default
RUN cp default.settings.php settings.php
RUN chown -R www-data:www-data .
RUN chmod -R 755 .
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Entrypoint script
COPY entrypoint.sh /
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]