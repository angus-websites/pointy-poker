#!/bin/sh

# Run our artisan commands
php artisan route:clear
php artisan config:clear
php artisan view:clear
#php artisan filament:optimize

# Migrate the database
php artisan migrate --force

echo "Starting worker Supervisor..."
# Start Supervisor in the background
supervisord -c /etc/supervisord.conf &

echo "Starting Octane with FrankenPHP..."
php artisan octane:frankenphp
