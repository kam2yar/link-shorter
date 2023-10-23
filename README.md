# Simple link shorter API

## Installation

Change the environment variables in `.env` file after copying the `.env.example` file.

```
cp .env.example .env
```

Run containers using docker-compose

```
docker-compose up -d
```

Install composer packages

```
docker-compose exec app composer install
```

Run the migrations

```
docker-compose exec app php vendor/bin/phoenix migrate -c config/migrations.php
```