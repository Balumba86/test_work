## Информация о сборке

    PHP: 8.1.4
    Laravel: 9.27.0
    Postgres: 13


## Старт работы
При первом запуске проекта, выполнить команду

```bash
make build
```
Соберутся контейнеры, 

Установятся зависимости,

Выполнятся базовые миграции,

Сгенерируется ключ приложения

## Непосредственно разработка
Доступные порты и сервисы можно посмотреть в файле docker-compose.yml

Необходимое окружение можно поменять в файле `src/example.env` и `src/.env` (последний не заливается в git).

## Поднятие бэкенда
Для начала работы делаем `make up`, при завершении работы делаем `make down`.

Хост API [http://localhost/api](http://localhost/api)

### Регистрация

POST: `/register`
```bash
{
    "name": "",
    "email": "",
    "password": ""
}
```
Response:
```bash
{
    "access_token": "",
    "token_type": "Bearer"
}
```

---

### Создание кошелька

POST: `/user/wallet/create`
```bash
{
    "currency": "RUB | USD"
}
```
Response:
```bash
{
    "data": {
        "user_id": 1,
        "currency": "USD",
        "updated_at": "2022-09-02T08:25:37.000000Z",
        "created_at": "2022-09-02T08:25:37.000000Z",
        "id": 2
    }
}
```

---

### Получение баланса кошелька

GET: `/user/wallet/{wallet_id}`

Response:
```bash
{
    "data": {
        "balance": "0.00",
        "currency": "USD"
    }
}
```

---

### Изменение баланса кошелька

PUT: `/user/wallet/update/{wallet_id}`
```bash
{
    "currency": "RUB",
    "operation_type": "debit",
    "amount": 100.15,
    "reason": "stock"
}
```
Response:
```bash
{
    "data": {
        "id": 2,
        "user_id": 1,
        "currency": "USD",
        "amount": "19.63",
        "created_at": "2022-09-02T08:25:37.000000Z",
        "updated_at": "2022-09-02T12:19:48.000000Z"
    }
}
```





