#!/bin/sh

# Run our artisan commands
php artisan route:clear
php artisan config:clear
php artisan view:clear
#php artisan filament:optimize

# Clear version cache
php artisan app:clear-version-cache

# Migrate the database
php artisan migrate --force

echo "Starting worker Supervisor..."
# Start Supervisor in the background
supervisord -c /etc/supervisord.conf &

echo "Starting Octane with FrankenPHP..."
php artisan octane:frankenphp --port 8001
