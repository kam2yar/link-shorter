<?php

use Pecee\SimpleRouter\SimpleRouter;

const BASE_DIR = __DIR__ . '/../';

require BASE_DIR . 'vendor/autoload.php';
require BASE_DIR . 'vendor/pecee/simple-router/helpers.php';
require BASE_DIR . 'routes/api.php';

SimpleRouter::setDefaultNamespace('\App\Controllers');

Dotenv\Dotenv::createImmutable(BASE_DIR)->safeLoad();

SimpleRouter::start();