<?php
require __DIR__.'/vendor/autoload.php';

use App\Core\Router;

$router = new Router();

require __DIR__. '/routes.php';

$router->resolve();