<?php

use Pecee\SimpleRouter\SimpleRouter;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../routes/api.php';
require __DIR__ . '/../vendor/pecee/simple-router/helpers.php';

SimpleRouter::setDefaultNamespace('\App\Controllers');

SimpleRouter::start();
