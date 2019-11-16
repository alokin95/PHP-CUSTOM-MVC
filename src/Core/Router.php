<?php

namespace App\Core;

class Router
{
    /**
     * @var Container $container
     */
    private $container;
    /**
     * @var RouteValidator $routeValidator
     */
    private $routeValidator;

    /**
     * @var RouteFormatter $routeFormatter;
     */
    private $routeFormatter;

    public $routes = [
        'GET' => [],
        'POST'=> []
    ];

    public function __construct($container)
    {
        $this->container = $container;
        $this->routeValidator = $this->container->get('route.validator');
        $this->routeFormatter = $this->container->get('route.formatter');
    }

    public function get($route = '', $controller = 'HomeController', $action = 'index')
    {
        try
        {
            if ($this->routeValidator->validateRoute($route))
            {
                $this->routes['GET'][$route] = [
                    'controller' => $controller,
                    'action'    => $action
                ];
            }
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }

    public function post($route = '', $controller = 'HomeController', $action = 'index')
    {
        try
        {
            if ($this->routeValidator->validateRoute($route))
            {
                $this->routes['POST'][$route] = [
                    'controller' => $controller,
                    'action'    => $action
                ];
            }
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }

    public function handle()
    {

        try {
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route => $arguments)
            {
                $methodArguments = $this->routeFormatter->matchRoute($route, $_SERVER['REQUEST_URI']);

                if (is_array($methodArguments)) {
                    $this->callAction($route, $arguments, $methodArguments);
                    return true;
                }
            }
            throw new ExceptionHandler("The route " . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . " was not defined");
        }
        catch (ExceptionHandler $e)
        {
            $e->handle();
        }
    }

    private function callAction($route, $arguments, $methodArguments)
    {
        $controllerClass = 'App\\Controllers\\' . $arguments['controller'];
        if (!class_exists($controllerClass))
        {
            throw new ExceptionHandler("Controller $controllerClass not found.");
        }
        $controllerInstance = new $controllerClass();


        $middleware = new AllowRequest();
        $middleware->allowRequest($controllerInstance);

        $action = $arguments['action'] . 'Action';
        if (!method_exists($controllerInstance, $action))
        {
            throw new ExceptionHandler("Method $action does not exist on $controllerClass.");
        }
        $controllerInstance->$action(...$methodArguments);
    }
}