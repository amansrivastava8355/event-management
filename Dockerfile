# Use the official PHP image as the base image
FROM php:8.2-apache

# Set the working directory inside the container
WORKDIR /var/www/html

# Install dependencies
ARG WWWGROUP
ARG USER_ID


RUN apt-get update && \
    apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer 
# Install PHP extensions

RUN docker-php-ext-install pdo_mysql zip gd
# Enable Apache Rewrite module
RUN a2enmod rewrite

# Set the Apache document root
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Copy the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN service apache2 restart

RUN chmod +x /usr/local/bin/docker-entrypoint

RUN chown -R www-data:www-data /var/www/html /var/run/apache2 /var/log/apache2
# RUN usermod -u $USER_ID www-data
# Expose port 80 for Apache
EXPOSE 80

# Set the entrypoint command
ENTRYPOINT ["docker-entrypoint"]