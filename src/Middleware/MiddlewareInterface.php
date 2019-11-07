<?php

namespace App\Middleware;

interface MiddlewareInterface
{
    /**
     * @return bool
     */
    public function handle();
}