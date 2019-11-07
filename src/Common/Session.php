<?php


namespace App\Common;


use App\Core\ExceptionHandler;

class Session
{
    public function getInstance()
    {
        return $_SESSION;
    }

    public function put($key, $value)
    {
        return $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        try {
            if (array_key_exists($key, (array)$_SESSION)) {
                return $_SESSION[$key];
            }
            return null;
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }
}