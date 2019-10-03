<?php

require __DIR__.'/vendor/autoload.php';

use App\Core\Router;

$router = new Router();

$router->get('/posts', ['controller' => 'PostController', 'action' => 'index']);
$router->post('/users', ['controller' => 'UserController', 'action' => 'create']);

$router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);