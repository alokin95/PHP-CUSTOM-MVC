<?php


namespace App\Core;


class Reflection
{
    /**
     * @var Container $container
     */
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function addProperties($controllerInstance)
    {
        $reflection = new \ReflectionClass($controllerInstance);

        $repository = $reflection->getProperty('repository');
        $response = $reflection->getProperty('response');
        $container = $reflection->getProperty('container');

        $repository->setAccessible(true);
        $response->setAccessible(true);
        $container->setAccessible(true);

        $repository->setValue($controllerInstance, $this->container->get('repository'));
        $response->setValue($controllerInstance, $this->container->get('response'));
        $container->setValue($controllerInstance, $this->container);

        return $controllerInstance;
    }
}
