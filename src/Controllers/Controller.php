<?php


namespace App\Controllers;


use App\Core\Container;
use App\Core\Response;

class Controller
{
    /**
     * @var Container
     */
    protected $container;
    /**
     * @var Response
     */
    protected $response;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->response = $this->container->get('response');
    }

    protected function get($key)
    {
        return $this->container->get($key);
    }
}