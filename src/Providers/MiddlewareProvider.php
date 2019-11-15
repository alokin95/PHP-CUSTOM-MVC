<?php


namespace App\Providers;

use App\Middleware\CheckIfLoggedInMiddleware;

class MiddlewareProvider
{
    private $middlewares = [
      'logged.check' => CheckIfLoggedInMiddleware::class,
    ];
}