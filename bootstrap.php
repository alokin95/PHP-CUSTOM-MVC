<?php
session_start();
require __DIR__.'/vendor/autoload.php';

use App\Core\Container;
use App\Core\Router;

$container = Container::getInstance();

require __DIR__.'/src/Common/helpers.php';

$router = new Router();

require __DIR__. '/routes.php';