# Link shorter API

## Installation

Copy the `.env.example` file and change the environment variables in `.env` file.

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