FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install Node dependencies & build assets
RUN npm install && npm run build

# Generate app key if not set
RUN php artisan key:generate --force || true

# Expose port (Railway provides $PORT)
EXPOSE 8080

# Start PHP built-in server directly (menghindari bug artisan serve dengan $PORT string)
CMD php -S 0.0.0.0:${PORT:-8080} -t public
