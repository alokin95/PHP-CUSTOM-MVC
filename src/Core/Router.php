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
        $this->routes['GET'][$route] = [
            'controller' => $params['controller'],
            'action'    => $params['action']
        ];
    }

    public function post($route = '', array $params = [])
    {
        $this->routes['POST'][$route] = [
            'controller' => $params['controller'],
            'action'    => $params['action']
        ];
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
}