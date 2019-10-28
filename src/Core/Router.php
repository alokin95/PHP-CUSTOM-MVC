<?php

namespace App\Core;

class Router
{
    public function get($route = '', array $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET')
        {
            return;
        }

        if ($this->validateRoute($route))
        {
            $methodArguments = $this->matchRoute($route, $_SERVER['REQUEST_URI']);

            if (is_array($methodArguments))
            {
                $this->resolve($params['controller'], $params['action'], $methodArguments);
            }
        }
    }

    public function post($route = '', array $params = [])
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST')
        {
            return;
        }

        if ($this->validateRoute($route))
        {
            $methodArguments = $this->matchRoute($route, $_SERVER['REQUEST_URI']);

            if ($methodArguments)
            {
                $this->resolve($params['controller'], $params['action'], $methodArguments);
            }
        }
    }

    private function validateRoute($route)
    {
        try
        {
            $route = trim($route, '/');

            $allowedUrlFormat = "/^([A-z0-9]{1,}|\{[A-z]{1,}\})(\/[A-z0-9]{1,}|\/\{[A-z]{1,}\})*([A-z0-9]{1,}|\/\{[A-z]{1,}\})*$/";

            if (!preg_match($allowedUrlFormat, $route))
            {
                throw new ExceptionHandler('Invalid route format');
            }

            if (!$this->checkDuplicateSlugs($route))
            {
                throw new ExceptionHandler('Duplicate slugs not allowed in a route');
            }

            return true;
        }
        catch(ExceptionHandler $e)
        {
            $e->handle();
        }
    }

    private function checkDuplicateSlugs($route)
    {
        $preg = '/\{[A-z]{1,}\}/';
        preg_match_all($preg, $route, $matched);

        $check_duplicate_values = array_count_values($matched[0]);

        foreach ($check_duplicate_values as $duplicate_value)
        {
            if ($duplicate_value > 1)
            {
               return false;
            }
        }

        return true;
    }

    private function matchRoute($route, $uri)
    {
        $initialRoute = explode('/', trim($route,'/'));

        $route = $this->replaceSlugsWithRegex($route);

        $uri = explode('/', trim($uri, '/'));

        if (count($uri) !== count($route))
        {
            return false;
        }

        foreach ($uri as $key => $item)
        {
            if ($route[$key] === '/(.*)+/')
            {
                if (!preg_match($route[$key], $item))
                {
                    return false;
                }
            }

            if ($route[$key] !== '/(.*)+/')
            {
                if ($item !== $route[$key])
                {
                    return false;
                }
            }
        }

        return $this->extractDynamicParameters($initialRoute, $uri);
    }

    private function replaceSlugsWithRegex($route)
    {
        $createRegex = "/\{[A-z]{1,}\}/";
        $array = explode('/', trim($route,'/'));
        $route = [];
        foreach ($array as $el)
        {
            $route[] = preg_replace($createRegex, "/(.*)+/", $el);
        }

        return $route;
    }

    private function extractDynamicParameters(array $initialRoute, array $uri)
    {
        $methodParameters = [];
        foreach($initialRoute as $key => $param)
        {
            if (strpos($param, '}'))
            {
                $methodParameters[] = $uri[$key];
            }
        }

        return $methodParameters;
    }

    private function resolve($controller, $action, array $methodArguments)
    {
        try {
            $controller = 'App\\Controllers\\' . $controller;
            if (!class_exists($controller))
            {
                throw new ExceptionHandler("Controller $controller not found.");
            }
            $controllerInstance = new $controller();
            $action = $action . 'Action';
            if (!method_exists($controllerInstance, $action))
            {
                throw new ExceptionHandler("Method $action does not exist on $controller.");
            }
            $action = $controllerInstance->$action(...$methodArguments);
        }
        catch (ExceptionHandler $e)
        {
            $e->handle();
        }

    }

}