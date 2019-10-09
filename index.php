<?php

require __DIR__.'/vendor/autoload.php';

use App\Core\Router;

$router = new Router();

$router->get('/post/{post}', ['controller' => 'PostController', 'action' => 'index']);
$router->post('/users', ['controller' => 'UserController', 'action' => 'create']);
dump($router->routes);die;
$router->resolve($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);