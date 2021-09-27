FROM devilbox/php-fpm-8.0

RUN apt-get update

# zip unzip install
RUN apt-get -y install zip unzip

# docker plugins install
RUN apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libpq-dev \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev

RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
&&  docker-php-ext-install -j$(nproc) gd

# nodejs install
RUN apt-get -y install nodejs npm \
&& npm install -g n \
&& n stable

RUN apt-get -y clean 

# php modules install
RUN docker-php-ext-install -j$(nproc) intl mbstring exif mysqli pdo_mysql opcache 

# Xdebug install
RUN pecl install xdebug \
 && docker-php-ext-enable xdebug

# composer install
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
&& php composer-setup.php \
&& mv composer.phar /usr/local/bin/composer