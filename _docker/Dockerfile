FROM php:8.2-apache

RUN apt-get update && apt-get install -y gettext-base \
    apt-utils \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libonig-dev \
    zip unzip \
    git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install -j$(nproc) gd bcmath zip pdo pdo_mysql mysqli curl mbstring && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN apt-get update && apt-get install -y sendmail

RUN a2enmod rewrite

# Install nodejs
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
 apt-get install -y nodejs

# copy apache-config
COPY _docker/apache-config/000-default.conf.template /etc/apache2/sites-available/000-default.conf.template

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# copy php-config
COPY _docker/php.ini /usr/local/etc/php/php.ini

# set Virtual Host Apache
CMD envsubst '\$VIRTUAL_HOST' < /etc/apache2/sites-available/000-default.conf.template > /etc/apache2/sites-available/000-default.conf && \
    echo "ServerName ${VIRTUAL_HOST}" >> /etc/apache2/apache2.conf && \
    apachectl -D FOREGROUND
