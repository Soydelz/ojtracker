FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nginx \
    nodejs \
    npm \
    supervisor

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . /var/www

# Copy nginx configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Create storage directories if they don't exist
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p storage/logs \
    && mkdir -p bootstrap/cache

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install NPM dependencies and build assets
RUN npm ci && npm run build

# Set proper permissions (critical for Laravel)
RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www/storage \
    && chmod -R 775 /var/www/bootstrap/cache

# Create startup script with better error handling
RUN echo '#!/bin/bash\n\
set -e\n\
echo "Starting Laravel setup..."\n\
\n\
# Clear any existing caches\n\
php artisan config:clear || true\n\
php artisan cache:clear || true\n\
php artisan view:clear || true\n\
\n\
# Run migrations\n\
php artisan migrate --force || echo "Migration failed, continuing..."\n\
\n\
# Create storage link\n\
php artisan storage:link || echo "Storage link exists"\n\
\n\
# Cache configuration\n\
php artisan config:cache\n\
php artisan route:cache\n\
php artisan view:cache\n\
\n\
echo "Starting PHP-FPM..."\n\
php-fpm -D\n\
\n\
echo "Starting Nginx..."\n\
nginx -g "daemon off;"\n\
' > /start.sh && chmod +x /start.sh

# Expose port
EXPOSE 80

# Start services
CMD ["/start.sh"]
