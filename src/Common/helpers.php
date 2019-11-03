<?php

if (!function_exists('session'))
{
    function session($key = null, $value = null)
    {
        if (is_null($key))
        {
            return app('session');
        }

        if (is_null($value))
        {
            return app('session')->get($key);
        }

        return app('session')->put($key, $value);
    }
}

if (!function_exists('app'))
{
    /**
     * @param $key
     * @return mixed
     */
    function app($key)
    {
        /**
         * @var \App\Core\Container $container
         */
        global $container;

        return $container->get($key);
    }
}