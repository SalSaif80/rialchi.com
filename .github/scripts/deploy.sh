#!/usr/bin/env bash
set -euo pipefail
live=$(realpath -e "$1")
stage=$2
[[ -f "$live/artisan" && -f "$live/.env" && -d "$live/storage" && -d "$live/public" ]] || {
    echo 'DEPLOY_PATH must contain the existing Laravel application.'
    exit 1
}
command -v rsync >/dev/null
cd "$stage"
tar -xzf release.tgz
mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction --no-progress --no-scripts
composer check-platform-reqs --no-dev
# Only mirror directories owned by the application. Keep runtime and uploaded files.
for dir in vendor app config resources routes; do
    rsync -a --delete-delay "$stage/$dir/" "$live/$dir/"
done
rsync -a --exclude=/cache/ bootstrap/ "$live/bootstrap/"
rsync -a --exclude='*.sqlite*' database/ "$live/database/"
rsync -a public/ "$live/public/"
rsync -a artisan composer.json composer.lock "$live/"
cd "$live"
# Artisan boots with cached providers before it can rediscover installed packages.
rm -f -- bootstrap/cache/{packages,services,config}.php
php artisan package:discover
php artisan config:cache
php artisan route:cache
php artisan view:cache
