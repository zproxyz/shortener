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
[docker container]$ cd ./src
[docker container]$ composer install
[docker container]$ ./yii migrate
[docker container]$ ./tests/bin/yii migrate
[docker container]$ ./vendor/bin/codecept run
```

1-ое задание
------------
```sql
SELECT a.* FROM items AS a
                  LEFT JOIN items AS a2
                    ON a.category_id = a2.category_id AND a.price <= a2.price
GROUP BY a.id
HAVING COUNT(a.category_id) <= 5
ORDER BY a.category_id, a.price DESC;
```
2-ое задание
------------
```sql
SELECT 
      YEAR(birthdate)year,
      COUNT(gender='M')male,
      COUNT(gender='F')female 
FROM users GROUP BY year
```
```sql
SELECT u.* FROM users u
LEFT JOIN users_banned ub ON u.id = ub.user_id
WHERE ub.user_id IS NULL
```
