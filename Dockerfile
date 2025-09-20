# Используем официальный образ PHP 8.3
FROM php:8.3-apache

# Устанавливаем зависимости (если нужны)
RUN apt-get update && apt-get install -y \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Копируем файлы из проекта
COPY . /var/www/html/

# Настройка Apache
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Запускаем Apache
CMD ["apache2-foreground"]