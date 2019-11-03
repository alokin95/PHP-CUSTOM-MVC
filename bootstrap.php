<?php
require __DIR__.'/vendor/autoload.php';

use App\Core\Container;
use App\Core\Router;

$router = new Router();

$container = Container::getInstance();

require __DIR__. '/routes.php';