FROM php:8.2-apache
RUN a2enmod rewrite

RUN apt-get update && docker-php-ext-install pdo \
  && php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
  && rm -rf /var/lib/apt/lists/*

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
ENV APACHE_LOG_DIR /var/www/html/storage/logs

COPY apache-config.conf /etc/apache2/sites-available/000-default.conf