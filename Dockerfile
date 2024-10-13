#選基本映像檔版本
FROM php:8.2-apache
#安裝依賴套件

RUN  apt-get update && apt-get install -y \
           zip\
           git\
           openssl\
           curl

#啟動 mod_rewrite apache模組，用來改寫請求URL的模組

RUN a2enmod rewrite 

#安裝php相關套件

RUN docker-php-ext-install pdo pdo_mysql 

#因為laravel以public資料夾作架站目錄，所以需要更改預設伺服器架站目錄成public

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#複製專案程式碼到容器裡

COPY . /var/www/html

#設定工作目錄(用來執行指令的目錄)

WORKDIR /var/www/html

#安裝composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#安裝專案的依賴套件

RUN composer install

#設定權限
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
