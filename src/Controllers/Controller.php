<?php


namespace App\Controllers;


class Controller
{

    public function __call($name, $arguments)
    {
        $method_name = $name . 'Action';

        if (method_exists($this, $method_name))
        {
            $this->$method_name();
        }
    }
}