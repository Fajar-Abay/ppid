# Stage 1: Composer Dependencies
FROM composer:2.7 AS composer_builder
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --ignore-platform-reqs

# Stage 2: Build Node.js assets
FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
# Copy vendor from composer_builder because Tailwind CSS needs it for Filament styles
COPY --from=composer_builder /app/vendor ./vendor
ENV NODE_OPTIONS="--dns-result-order=ipv4first"
RUN npm run build

# Stage 3: Final Production Image (Pre-compiled, no compile wait times)
FROM serversideup/php:8.3-fpm-nginx

# Copy application files (serversideup runs as 'webuser' UID/GID 1000 by default)
COPY --from=composer_builder --chown=webuser:webuser /app /var/www/html
COPY --from=node_builder --chown=webuser:webuser /app/public/build /var/www/html/public/build
