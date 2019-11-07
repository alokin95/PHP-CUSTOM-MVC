<?php

$router->get('/', 'FrontController', 'index');
$router->get('posts', 'PostController', 'index');
$router->get('posts/{post}', 'PostController', 'show');
$router->post('login', 'AuthController', 'login');