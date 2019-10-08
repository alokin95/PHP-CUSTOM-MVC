<?php

namespace App\Core;

class Router
{

    private $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($route = '', array $params = [])
    {

        if ($this->validate_route($route))
        {
            $this->routes['GET'][$route] = [
                'controller'    => $params['controller'],
                'action'        => $params['action']
            ];
        }
    }

    public function post($route = '', array $params = [])
    {
        if ($this->validate_route($route))
        {
            $this->routes['POST'][$route] = [
                'controller' => $params['controller'],
                'action'    => $params['action']
            ];
        }
    }

    public function resolve($method, $uri)
    {
        if (array_key_exists($uri, $this->routes[$method]))
        {
            $controller = 'App\Controllers' . '\\' . $this->routes[$method][$uri]['controller'];
            $controller_action = $this->routes[$method][$uri]['action'];
            $controller = new $controller;
            $controller->$controller_action();
        }
    }

    private function validate_route($route)
    {
        try
        {
            $route = trim($route, '/');

            $allowed_url_format = "/^([A-z0-9]{1,}|\{[A-z]{1,}\})(\/[A-z0-9]{1,}|\/\{[A-z]{1,}\})*([A-z0-9]{1,}|\/\{[A-z]{1,}\})*$/";

            if (preg_match($allowed_url_format, $route))
            {
                return true;
            }
            throw new ExceptionHandler('Invalid route format');

        }catch(ExceptionHandler $e)
        {
            $e->handle();
        }
    }
}