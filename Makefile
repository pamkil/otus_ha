up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-up php-init


#==docker===========================================================

docker-up:
	docker-compose -f docker/docker-compose.yml up -d

docker-down:
	docker-compose -f docker/docker-compose.yml down --remove-orphans

docker-down-clear:
	docker-compose -f docker/docker-compose.yml down -v --remove-orphans

docker-build:
	docker-compose -f docker/docker-compose.yml build

docker-logs:
	docker-compose -f docker/docker-compose.yml logs gateway

ps:
	docker-compose -f docker/docker-compose.yml ps

#====end docker=========================================================


#==php=======================
php:
	docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli bash

php-init: php-pack-del php-install yii-init yii-migrate

php-pack-del:
	rm -Rf ./app/vendor

php-install:
	docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli composer install

yii-init:
	docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli php init --env=Development --overwrite=y

yii-migrate:
	docker-compose -f docker/docker-compose.yml run --user="1000" --rm -w /app php-cli php yii migrate/up --interactive=0
#==end php===================
