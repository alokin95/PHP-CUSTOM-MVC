<?php


namespace App\Core;

use App\Middleware\MiddlewareInterface;
use App\Middleware\MiddlewareProvider;

class AllowRequest
{

    public function allowRequest($controllerInstance)
    {
        $reflection = new \ReflectionClass($controllerInstance);
        $middlewarePropery = $reflection->getProperty('middleware');
        $middlewarePropery->setAccessible(true);
        $registeredMiddlewares = $middlewarePropery->getValue(new $controllerInstance);

        if ($registeredMiddlewares)
        {
            $reflection = new \ReflectionClass(MiddlewareProvider::class);
            $providedMiddlewares = $reflection->getProperty('middlewares');
            $providedMiddlewares->setAccessible(true);
            $middlewares = $providedMiddlewares->getValue(new MiddlewareProvider());


            foreach ($registeredMiddlewares as $middleware)
            {
                if (array_key_exists($middleware, $middlewares))
                {
                    $middleware = new $middlewares[$middleware];
                    $middleware->handle();
                }
            }
        }
    }
}
