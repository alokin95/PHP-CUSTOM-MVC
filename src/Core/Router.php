<?php

namespace App\Core;

class Router
{

    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($route = '', array $params = [])
    {
        if ($this->validate_route($route))
        {
            $remove_braces = "/[\{\}]/";
            $uri = preg_replace($remove_braces, '', $route );

            $this->routes['GET'][$uri] = [
                'controller'    => $params['controller'],
                'action'        => $params['action'],
                'original_'     => $route
            ];
        }
    }

    public function post($route = '', array $params = [])
    {
        if ($this->validate_route($route))
        {
            $remove_braces = "/[\{\}]/";
            $uri = preg_replace($remove_braces, '', $route );

            $this->routes['POST'][$uri] = [
                'controller'    => $params['controller'],
                'action'        => $params['action'],
                'arguments'     => $route
            ];
        }
    }

    public function resolve($method, $uri)
    {
        try {
            if (!array_key_exists($uri, $this->routes[$method]))
            {
                throw new ExceptionHandler('Route is not defined.');
            }

            $controller = 'App\Controllers' . '\\' . $this->routes[$method][$uri]['controller'];
            $controller_action = $this->routes[$method][$uri]['action'];
            $controller = new $controller;
            $controller->$controller_action();

        } catch(ExceptionHandler $e)
        {
            $e->handle();
        }
    }

    private function validate_route($route)
    {
        try
        {
            $route = trim($route, '/');

            $allowed_url_format = "/^([A-z0-9]{1,}|\{[A-z]{1,}\})(\/[A-z0-9]{1,}|\/\{[A-z]{1,}\})*([A-z0-9]{1,}|\/\{[A-z]{1,}\})*$/";

            if (!preg_match($allowed_url_format, $route))
            {
                throw new ExceptionHandler('Invalid route format');
            }

            return true;

        }catch(ExceptionHandler $e)
        {
            $e->handle();
        }
    }

    private function extract_action_arguments($route)
    {
        try {
            $preg = '/\{[A-z]{1,}\}/';
            preg_match_all($preg, $route, $matched);

            $check_duplicate_values = array_count_values($matched[0]);

            $arguments = [];

            foreach ($check_duplicate_values as $duplicate_value)
            {
                if ($duplicate_value > 1)
                {
                    throw new ExceptionHandler('Duplicate slugs not allowed in a route.');
                }
            }

            foreach ($matched[0] as $parameter)
            {
                $arguments[] = $this->strip_curly_braces($parameter);
            }

            return $arguments;

        }catch (\Exception $exception)
        {
            $exception->handle();
        }
    }

    private function strip_curly_braces($string)
    {
        $opening = strpos($string, '{');
        $closing = strpos($string, '}');
        return substr($string, $opening+1, $closing-$opening-1);
    }
}