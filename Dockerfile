FROM php:7.2.4-alpine3.7

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

CMD ["/bin/sh"]

ENTRYPOINT ["/bin/sh", "-c"]