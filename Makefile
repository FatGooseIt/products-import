init: docker-down-clear docker-build docker-up app-init
app-init: app-clear-var-cache composer-install app-grant-db app-migrations app-warmup
validate: tests

docker-up:
	docker compose up -d

docker-build:
	docker compose build

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down -v --remove-orphans

app-init: app-clear-var-cache composer-install

app-clear-var-cache:
	docker compose run --rm products-import-php-fpm rm -rf /var/www/app/var/cache

app-grant-db:
	docker compose exec -T products-import-mysql /usr/bin/mysql -uroot -proot -e "GRANT ALL ON *.* TO user@'%';FLUSH PRIVILEGES;"

app-migrations:
	docker compose run --rm products-import-php-fpm php bin/console do:database:drop -nq --force --if-exists
	docker compose run --rm products-import-php-fpm php bin/console do:database:create -nq
	docker compose run --rm products-import-php-fpm php bin/console do:mi:mi -n

dif:
	docker compose run --rm products-import-php-fpm php bin/console do:mi:di

mig:
	docker compose run --rm products-import-php-fpm php bin/console do:mi:mi -n

mig-gen:
	docker compose run --rm products-import-php-fpm php bin/console do:mi:generate

app-warmup:
	docker compose run --rm products-import-php-fpm php bin/console cache:warmup

tests:
	docker compose run --rm products-import-php-fpm composer phpunit

bash:
	docker compose exec php bash

composer-install:
	docker compose run --rm -it products-import-php-fpm composer install

composer-update:
	docker compose run --rm -it products-import-php-fpm composer update

composer-require:
	docker compose run --rm -it products-import-php-fpm composer req $(filter-out $@,$(MAKECMDGOALS)) --with-all-dependencies

composer-remove:
	docker compose run --rm -it products-import-php-fpm composer rem $(filter-out $@,$(MAKECMDGOALS))

composer-check:
	docker compose run --rm products-import-php-fpm composer outdated

command:
	docker compose run --rm -it products-import-php-fpm $(filter-out $@,$(MAKECMDGOALS))

console:
	docker compose run --rm -it products-import-php-fpm php bin/console $(filter-out $@,$(MAKECMDGOALS))

setown:
	sudo chown -R `id -u`:`id -g` app

test:
	docker compose run --rm products-import-php-cli php bin/phpunit

products-import:
	docker compose run --rm products-import-php-cli php bin/console app:products:import

products-import-test:
	docker compose run --rm products-import-php-cli php bin/console app:products:import test

psalm:
	docker compose run --rm products-import-php-cli composer psalm
