#!/usr/bin/env bash
set -e

# Render provides PORT (default 10000)
: "${PORT:=10000}"

# Inject PORT into nginx config
envsubst '${PORT}' < /etc/nginx/http.d/default.conf > /etc/nginx/http.d/default.conf.tmp
mv /etc/nginx/http.d/default.conf.tmp /etc/nginx/http.d/default.conf

# Laravel optimizations / setup
php artisan config:cache || true
php artisan route:cache || true
php artisan storage:link || true

# If you have a DB connected on Render, run migrations
php artisan migrate --force || true

exec /usr/bin/supervisord -c /etc/supervisord.conf