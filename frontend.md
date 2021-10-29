Для добавления в проект node, npm и yarn, в `Dockerfile` необходимо расскоментировать строку

    RUN apk add --no-cache nodejs npm yarn

Далее в `Makefile` раскомментировать строку 

    docker-compose exec php yarn


Точкой входа скриптов служит `src/resources/js/app.js`

Точкой входа стилей служит `src/resources/sass/app.scss`

## Поднятие фронтенда
Для запуска слушателя делаем `make dev`

Для боевой сборки фронта (для теста, например) делаем `make prod`
