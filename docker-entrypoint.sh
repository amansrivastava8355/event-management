#!/bin/bash
# Set environment-specific configurations here
# Start Apache in the foreground
chown -R www-data:www-data /var/www/html/**

composer install && apache2-foreground