<?php

namespace App\Core;

use App\Common\Session;
use App\Controllers\Controller;

class Container
{

    private static $instance;
    private $lazyLoad = [];
    public $services = [];

    private function registerServices()
    {
        $this->services = [
           'response' => function( self $container ) {
                return new Response();
            },
            'session' => function (self $container) {
            return new Session();
            },
            'repository' => function (self $container) {
                return new Repository();
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

            if (!array_key_exists($service, $this->lazyLoad))
            {
                $closure = $this->services[$service];
                $this->lazyLoad[$service] = $closure($this);
            }

            return $this->lazyLoad[$service];
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