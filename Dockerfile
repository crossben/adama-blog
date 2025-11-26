# -----------------------
# 1. Build front-end assets
# -----------------------
FROM node:20 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build    # <-- this generates /public/build


# -----------------------
# 2. PHP + Apache image
# -----------------------
FROM php:8.3-apache

WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    zip \
    curl \
    libicu-dev \
    libpq-dev \
    postgresql-client && \
    docker-php-ext-install intl && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set DocumentRoot
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|g' /etc/apache2/sites-available/000-default.conf

# Copy app files
COPY . /var/www

# Copy the Vite build from the Node stage
COPY --from=frontend /app/public/build /var/www/public/build

# Install Composer and app dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Cache Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Fix permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE 80
