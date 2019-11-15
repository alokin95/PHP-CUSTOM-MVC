<?php

namespace App\Middleware;

interface MiddlewareInterface
{
    /**
     * Runs on every request.
     */
    public function handle();
}