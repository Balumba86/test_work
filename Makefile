# Выводит список команд make-файла с описанием
help:
	sed -nE "s/^([[:alpha:]]*:)/\1/p; s/^(#[[:blank:]]*)([[:graph:]].*)$\/-\ \2/p; s/^#[[:blank:]]*$\//p" Makefile

# Запускает контейнеры
up:
	docker-compose up -d

# Останавливает контейнеры
down:
	docker-compose down

# Запускает sh в контейнере php
exec:
	docker-compose exec php sh

# Собирает контейнеры
build:
	cp example.env .env
	cp src/.env.example src/.env

	docker-compose pull
	docker-compose build
	docker-compose up -d

	docker-compose exec php composer install
	#docker-compose exec php yarn

	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan key:generate

	docker-compose down

# Запускает yarn watch в контейнере для разработки фронтенда
dev:
	docker-compose exec php yarn watch

# Запускает yarn production для сборки билда
prod:
	docker-compose exec php yarn production

# Запускает анализатор кода
analyzer:
	docker-compose exec php ./vendor/bin/phpcs --error-severity=1 --warning-severity=8 --standard=PSR12 app database routes

# Запускает анализатор кода и выполняет фикс по стандарту PSR12
analyser-fix:
	docker-compose exec php ./vendor/bin/phpcs --error-severity=1 --warning-severity=8 --standard=PSR12 app database routes
