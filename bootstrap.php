<?php
session_start();
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/src/Common/helpers.php';

use App\Core\Container;
use App\Core\Router;

$container = Container::getInstance();

$router = new Router($container);

require __DIR__. '/public/routes.php';