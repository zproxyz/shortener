<p align="center">
    <h1 align="center">Yii 2 Сокращатель Ссылок</h1>
</p>

Требования
------------
- Docker

Установка
------------
```bash
$ docker-compose up --build
$ docker exec -it yii2-shortener-php-fpm bash
$ cd ./src
$ composer install
$ ./yii migrate
$ ./tests/bin/yii migrate
$ ./vendor/bin/codecept run
```
