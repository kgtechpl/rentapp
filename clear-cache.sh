#!/bin/bash
# Skrypt do wyczyszczenia cache Laravel i Composer
# Uruchom na serwerze: bash clear-cache.sh

echo "Czyszczenie cache Laravel..."

# Usuwanie plików cache bootstrap
rm -f bootstrap/cache/routes-v7.php
rm -f bootstrap/cache/services.php
rm -f bootstrap/cache/packages.php
rm -f bootstrap/cache/config.php

# Usuwanie cache storage
rm -rf storage/framework/cache/data/*
rm -rf storage/framework/views/*

echo "Przebudowa autoloadera Composer..."
composer dump-autoload

echo "Czyszczenie cache Artisan..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "✓ Cache wyczyszczony! Możesz teraz uruchomić migrację:"
echo "  php artisan migrate"
