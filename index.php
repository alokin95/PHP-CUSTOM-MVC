<?php

require __DIR__.'/vendor/autoload.php';

use App\Core\Router;

$router = new Router();

$router->get('posts', ['controller' => 'PostController', 'action' => 'index']);
$router->get('posts/{post}', ['controller' => 'PostController', 'action' => 'show']);