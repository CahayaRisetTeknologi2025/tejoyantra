#!/bin/bash
# deploy.sh

echo "Starting Laravel deployment..."

# Copy environment file
if [ ! -f .env ]; then
    cp .env.example .env
    echo ".env file created from .env.example"
fi

# Install PHP dependencies
docker-compose run --rm app composer install --no-dev --optimize-autoloader

# Generate application key
docker-compose run --rm app php artisan key:generate

# Run database migrations
docker-compose run --rm app php artisan migrate --force

# Cache configuration
docker-compose run --rm app php artisan config:cache

# Cache routes
docker-compose run --rm app php artisan route:cache

# Cache views
docker-compose run --rm app php artisan view:cache

# Storage link
docker-compose run --rm app php artisan storage:link

# Install filament assets
docker-compose run --rm app php artisan filament:assets --quiet

# Set proper permissions
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache

echo "Deployment completed!"
