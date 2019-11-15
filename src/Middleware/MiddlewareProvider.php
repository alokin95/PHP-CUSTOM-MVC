<?php


namespace App\Middleware;


class MiddlewareProvider
{
    private $middlewares = [
      'logged.check' => CheckIfLoggedInMiddleware::class,
    ];
}