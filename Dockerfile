FROM php:7-apache

RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN /usr/sbin/a2enconf fqdn
RUN /usr/sbin/a2enmod rewrite

RUN docker-php-ext-install pdo_mysql

COPY . /var/www/html
COPY run/fiche.conf /etc/apache2/sites-available/fiche.conf
RUN a2dissite 000-default.conf && a2ensite fiche
RUN /etc/init.d/apache2 restart

# Install composer and load all dependencies
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
