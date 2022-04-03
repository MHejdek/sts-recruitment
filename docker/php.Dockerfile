FROM php:8.1-apache

RUN a2enmod rewrite

# Install required packages for composer install
RUN apt-get update && \
    apt-get install -y git zip unzip

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    chmod +x /usr/local/bin/composer && \
    php -r "unlink('composer-setup.php');"

# Install required php extensions for the project
RUN curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions gd && \
    install-php-extensions pdo_mysql


COPY /docker/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY . /var/www

WORKDIR /var/www

CMD ["apache2-foreground"]