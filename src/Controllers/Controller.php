<?php

namespace App\Controllers;

use App\Core\Container;
use App\Core\Repository;
use App\Core\Response;
use App\Middleware\AuthorizesRequests;

class Controller
{
    use AuthorizesRequests;
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

    protected $middleware;

    public function __construct()
    {
        $this->container = Container::getInstance();
        $this->response = $this->container->get('response');
        $this->repository = $this->container->get('repository');
    }
}