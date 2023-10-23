<?php

const BASE_DIR = __DIR__ . '/../';

Dotenv\Dotenv::createImmutable(BASE_DIR)->safeLoad();

return [
    'migration_dirs' => [
        'main' => BASE_DIR . 'database/migrations',
    ],
    'environments' => [
        'default' => [
            'adapter' => 'mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'db_name' => $_ENV['DB_DATABASE'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci'
        ]
    ],
    'default_environment' => 'default',
    'log_table_name' => 'migrations',
];