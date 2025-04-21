FROM php:8.3-fpm-bookworm

# Update base image and install security patches first
RUN apt-get update && \
    apt-get upgrade -y --no-install-recommends && \
    apt-get install -y --no-install-recommends \
    ca-certificates \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions with security hardening
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    && docker-php-source delete

# Install Composer securely
RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/local/bin --filename=composer --2 && \
    chmod +x /usr/local/bin/composer && \
    composer self-update --clean-backups

WORKDIR /var/www/html

# Security best practices
RUN groupadd -g 1000 appuser && \
    useradd -u 1000 -g appuser -d /var/www/html appuser && \
    chown -R appuser:appuser /var/www/html

USER appuser

# Cleanup
RUN rm -rf /tmp/* /var/tmp/*