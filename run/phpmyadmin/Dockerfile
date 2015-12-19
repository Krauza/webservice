FROM php:7-apache

RUN echo "ServerName localhost" | tee /etc/apache2/conf-available/fqdn.conf
RUN /usr/sbin/a2enconf fqdn
RUN /usr/sbin/a2enmod rewrite
RUN docker-php-ext-install mbstring mysqli

ENV PHPMYADMIN_VERSION 4.5.2

# download & install phpmyadmin
RUN cd /tmp && curl -O -L https://files.phpmyadmin.net/phpMyAdmin/${PHPMYADMIN_VERSION}/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages.tar.gz
RUN tar -zxf /tmp/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages.tar.gz -C /tmp
RUN mkdir -p /data \
  && mv /tmp/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages /data/ \
  && mv /data/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages /data/phpmyadmin

RUN echo 0 > /dev/null

WORKDIR /data/phpmyadmin

RUN chown -R www-data:www-data .
RUN chmod -R 775 .

ADD vhost.conf /etc/apache2/sites-available/phpmyadmin.conf
ADD config.inc.php /data/phpmyadmin/config.inc.php

RUN a2dissite 000-default.conf && a2ensite phpmyadmin
RUN /etc/init.d/apache2 restart
