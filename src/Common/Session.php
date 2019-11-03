<?php


namespace App\Common;


use App\Core\ExceptionHandler;

class Session
{
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
            throw new ExceptionHandler("Session $key does not exist");
        }
        catch (ExceptionHandler $exception)
        {
            $exception->handle();
        }
    }
}