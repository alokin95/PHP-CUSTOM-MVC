<?php

if (!function_exists('session'))
{
    function session($key = null, $value = null)
    {
        if (is_null($key))
        {
            return app('session')->getInstance();
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
        header("Location: http://$server/".trim($uri, '/'));
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

if (!function_exists('ENV'))
{
    function ENV($key)
    {
        $env = file(__DIR__.'/../../.env');

        $searchedKey = "";

        foreach ($env as $row)
        {
            $row = explode('=', trim($row));

            if ($row[0] == $key)
            {
                $searchedKey = $row[1];
            }
        }

        return $searchedKey;
    }
}

if (!function_exists('request'))
{
    function request($key)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                return $_GET[$key];
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                return $_POST[$key];
            }
            throw new \App\Core\ExceptionHandler("No $key was found in the request payload");
        }
        catch(\App\Core\ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }
}