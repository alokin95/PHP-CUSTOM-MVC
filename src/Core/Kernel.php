<?php


namespace App\Core;


class Kernel
{
    /**
     * @var Container $container
     */
    private $container;
    /**
     * @var Router $router
     */
    private $router;

    public function __construct($container)
    {
        $this->container = $container;
        $this->router = $this->container->get('router');
    }

    public function handle()
    {
        $this->router->handle();
    }
}