<?php


namespace App\Controllers;


use App\Core\Container;
use App\Core\Repository;
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
    /**
     * @var Repository
     */
    protected $repository;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->response = $this->container->get('response');
        $this->repository = $this->container->get('repository');
    }

    protected function get($key)
    {
        return $this->container->get($key);
    }
}