FROM php:7.4.7-apache

# PHPの拡張モジュールをインストール
RUN docker-php-ext-install bcmath pdo_mysql

# composerの設定はCOPYコマンドを使うことにする
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get -y update && \
# composerとかに必要なパッケージ
apt-get -y install zip unzip wget && \
# mod_rewriteが有効になってないので有効にする
a2enmod rewrite



