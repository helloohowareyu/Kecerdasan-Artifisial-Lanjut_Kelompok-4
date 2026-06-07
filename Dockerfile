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

# Expose port (Railway menyediakan $PORT)
EXPOSE 8080

# Salin env, buat database sqlite, jalankan migrasi, generate key, lalu jalankan PHP built-in server saat startup container
CMD php -r "file_exists('.env') || copy('.env.example', '.env');" && \
    php artisan key:generate --force && \
    mkdir -p database && touch database/database.sqlite && \
    php artisan migrate --force && \
    php -S 0.0.0.0:${PORT:-8080} -t public
