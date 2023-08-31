FROM php:8.2-apache

# Instalar dependências
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip

RUN docker-php-ext-install zip

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Copiar arquivo de configuração do Apache
COPY docker/apache/default.conf /etc/apache2/sites-available/000-default.conf

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Executar o composer install ao subir o projeto
RUN composer install

# Permissões de arquivo
RUN chown -R www-data:www-data /var/www/html

# Porta exposta pelo Apache
EXPOSE 80

# Iniciar o Apache
CMD ["apache2-foreground"]
