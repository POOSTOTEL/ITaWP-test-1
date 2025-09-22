FROM php:8.1-apache

# Установка расширений PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Включение mod_rewrite для Apache
RUN a2enmod rewrite

# Копирование файлов приложения
COPY . /var/www/html/

# Установка прав
RUN chown -R www-data:www-data /var/www/html

# Копируем init_database.php в корень
COPY init_database.php /var/www/html/