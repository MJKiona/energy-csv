FROM php:8.2-cli
COPY . /usr/app/kiona-csv
WORKDIR /usr/app/kiona-csv

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y git
RUN curl -s https://getcomposer.org/installer | php
RUN php ./composer.phar install
RUN php ./composer.phar dump-autoload

CMD ["php", "./index.php"]
