# ================ Stage 1: Composer dependencies =====================
FROM composer:2 AS composer_prod
RUN apk add --no-cache icu-dev \
    && docker-php-ext-install intl
WORKDIR /app
COPY . .

# Auth using auth.json
RUN --mount=type=secret,id=composer_auth \
    export COMPOSER_AUTH="$(cat /run/secrets/composer_auth | tr -d '\n')" && \
    composer install \
      --no-interaction \
      --no-dev \
      --prefer-dist \
      --optimize-autoloader

# RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader
RUN rm -rf /root/.composer/cache


# =============== Stage 2: Frontend build with Node.js ===============
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
RUN npm ci
COPY . .
COPY --from=composer_prod /app/vendor ./vendor
RUN npm run build && npm cache clean --force

# ============== Stage 3: Setup PHP and Laravel for production ===============
FROM dunglas/frankenphp:1-php8.4-alpine AS prod

# Install system dependencies
RUN apk add --no-cache \
    curl \
    zip \
    unzip \
    git \
    oniguruma-dev \
    icu-dev \
    libzip-dev

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    mbstring \
    zip \
    intl

# Copy vendor files from composer stage
COPY --from=composer_prod /app/vendor /var/www/html/vendor

# Copy frontend build files
COPY --from=frontend /app/public /var/www/html/public

# Copy project files
COPY . /var/www/html

# Set workdir
WORKDIR /var/www/html

# Copy our prod script and set permissions
COPY server/start.sh /start.sh
RUN chmod +x /start.sh


CMD ["sh", "/start.sh"]
