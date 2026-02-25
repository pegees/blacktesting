#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Run migrations
php artisan migrate --force

# Start server
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
