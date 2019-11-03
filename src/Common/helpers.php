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

if (!function_exists('response'))
{
    function response()
    {
        return app('response');
    }
}

if (!function_exists('redirect'))
{
    function redirect($uri)
    {
        $server = $_SERVER['HTTP_HOST'];
        header("Location: http://$server/".$uri);
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