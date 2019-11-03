<?php

function session($key = null, $value = null)
{
    /**
     * @var \App\Core\Container $container
     */
    global $container;

    if (is_null($key))
    {
        return $container->get('session');
    }

    if (is_null($value))
    {
        return $container->get('session')->get($key);
    }

    return $container->get('session')->put($key, $value);
}