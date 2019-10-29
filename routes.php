<?php

$router->get('posts', 'PostController', 'show');
$router->post('users', 'PostController', 'store');