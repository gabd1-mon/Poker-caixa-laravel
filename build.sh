#!/usr/bin/env bash
# exit on error
set -o errexit

# Instala as dependências do PHP
composer install --no-dev --no-interaction --compile --optimize-autoloader

# Instala as dependências do frontend e compila os assets
npm install
npm run build

# Executa as migrações do banco de dados
php artisan migrate --force
