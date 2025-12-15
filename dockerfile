# ---- 1) Build frontend (Vite) ----
FROM node:20-alpine AS nodebuild
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- 2) Install PHP deps (Composer) ----
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# ---- 3) Runtime: PHP-FPM + Nginx ----
FROM php:8.3-fpm-alpine

# System deps + nginx + supervisor
RUN apk add --no-cache \
    nginx supervisor bash curl git \
    icu-dev oniguruma-dev zlib-dev libzip-dev \
    freetype-dev libjpeg-turbo-dev libpng-dev

# PHP extensions commonly needed for Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    intl mbstring pdo pdo_mysql pdo_pgsql zip gd opcache

WORKDIR /var/www/html

# Copy app source
COPY . .

# Copy vendor from composer stage
COPY --from=vendor /app/vendor ./vendor

# Copy built assets from node stage (Vite default output is public/build)
COPY --from=nodebuild /app/public/build ./public/build

# Nginx + supervisor + start script
COPY conf/nginx/default.conf /etc/nginx/http.d/default.conf
COPY conf/supervisord.conf /etc/supervisord.conf
COPY scripts/start.sh /start.sh
RUN chmod +x /start.sh

# Laravel writable dirs
RUN mkdir -p storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000
CMD ["/start.sh"]