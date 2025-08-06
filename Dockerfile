# Usa uma imagem oficial do PHP com FPM (FastCGI Process Manager)
FROM php:8.3-fpm

# Instala extensões PHP necessárias (ex: pdo_pgsql para PostgreSQL, mbstring)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    git \
    unzip \
    libonig-dev \
    && docker-php-ext-install pdo_pgsql mbstring zip

# Instala o Composer (gerenciador de dependências PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho dentro do container
WORKDIR /var/www/html

# Expõe a porta 9000 (padrão do PHP-FPM)
EXPOSE 9000

# Comando para iniciar o PHP-FPM
CMD ["php-fpm"]