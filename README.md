Запуск docker машин
---
Необходимо выполнить в консоле следующие команды для работы должна быть установлена утилита make:

Первый запуск

```
make init
```

---
Запуск docker машин

```
make start
```

___
Для остановки docker машин

```
make down
```

Если нет утилита make, то выполняем следующее:

Первый запуск

```
docker compose -f docker/docker-compose.yml up -d
rm -Rf ./app/vendor
docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli-o composer install
docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli-o php init --env=Development --overwrite=y
docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli-o php yii migrate/up --interactive=0
```

Запуск

```
docker compose -f docker/docker-compose.yml up -d
docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli-o php yii migrate/up --interactive=0
```

Для работы с апи необходимо зайти в swagger по адресу
___
[API http://localhost:8000/swagger/v1#/Auth](http://localhost:8000/swagger/v1#/Auth)

```
http://localhost:8000/swagger/v1#/Auth
```
