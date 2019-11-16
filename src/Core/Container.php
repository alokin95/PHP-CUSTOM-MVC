<?php

namespace App\Core;

use App\Common\Session;
use App\Controllers\Controller;

class Container
{

    private static $instance;
    private $definitions = [];
    public $services = [];

    private function registerServices()
    {
        $this->services = [
            'kernel'            => function ( self $container ) {
                return new Kernel($container);
            },
            'router'   => function ( self $container) {
                return new Router($container);
            },
            'route.validator'   => function ( self $container) {
                return new RouteValidator();
            },
            'route.formatter'   => function ( self $container) {
                return new RouteFormatter();
            },
            'reflection'        => function ( self $container) {
                return new Reflection($container);
            },
            'connection'        => function ( self $container) {
                $connection = new Connection(ENV('DB_NAME'), ENV('DB_USER'), ENV('DB_PASSWORD'), ENV('DB_HOST'));
                return $connection->connect();
            },
           'response'           => function( self $container ) {
                return new Response();
            },
            'session'           => function (self $container) {
            return new Session();
            },
            'repository'        => function (self $container) {
                return new Repository($container);
            }
        ];
    }

    public function get($service)
    {
        try {
            if (!array_key_exists($service, $this->services))
            {
                throw new ExceptionHandler("Service $service not found.");
            }

            if (!array_key_exists($service, $this->definitions))
            {
                $closure = $this->services[$service];
                $this->definitions[$service] = $closure($this);
            }

            return $this->definitions[$service];
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new Container();
            self::$instance->registerServices();
        }

        return self::$instance;
    }
}