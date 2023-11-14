# Dockerfile used by docker-compose.yml in DEV server
FROM php:7.4-apache

# Install (but also activate mysqli extension)
RUN docker-php-ext-install mysqli

# Create default certificates directory
RUN mkdir -p /etc/apache2/default_ssl

# Activate SSL
RUN a2enmod ssl && a2enmod rewrite

# Copy default ssl files
COPY ./default_ssl/fullchain.pem /etc/apache2/default_ssl/fullchain.pem
COPY ./default_ssl/privkey.pem /etc/apache2/default_ssl/privkey.pem

# Copy apache config
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port HTTP and HTTPS
EXPOSE 80
EXPOSE 443