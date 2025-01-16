init: docker-network down build up composer-install db-create p-init f-init
fresh: p-init f-init
p-init:
	docker compose run --rm products-import-php-fpm composer p-init
f-init:
	docker compose run --rm products-import-php-fpm composer f-init

docker-network:
	docker network create --driver=bridge --opt com.docker.network.driver.mtu=1440 --subnet=192.168.221.0/26 finturf-local || true

#Docker compose
build:
	docker compose build
down:
	docker compose down --remove-orphans
up:
	docker compose up -d

#App
bash:
	docker compose run --rm products-import-php-fpm bash
composer-install:
	docker compose run --rm products-import-php-fpm composer install
db-create:
	docker compose run --rm products-import-php-fpm php bin/console do:database:drop -nq --force --if-exists
	docker compose run --rm products-import-php-fpm php bin/console do:database:create -nq
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:migrate --no-interaction
schema-update:
	docker compose run --rm products-import-php-fpm php bin/console d:schema:update --force
db-migrate:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:migrate --no-interaction
db-migrate-prev:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:migrate prev
db-migrate-status:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:current
db-migrate-latest:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:latest --no-interaction
db-diff:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:migrations:diff
schema-validate:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:schema:validate
clear-cache:
	if [ -d app/var/cache/ ]; \
	then \
		sudo rm -R app/var/cache/; \
		sudo chmod -R 777 app/var; \
	fi;
load-fixtures:
	docker compose run --rm products-import-php-fpm php bin/console doctrine:fixtures:load -nq

#DevTools
app-cs-fix:
	docker compose run -e PHP_CS_FIXER_IGNORE_ENV=1 --rm products-import-php-fpm vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.php
app-stan:
	docker compose run --rm products-import-php-fpm composer phpstan
pre-push: app-cs-fix app-stan
