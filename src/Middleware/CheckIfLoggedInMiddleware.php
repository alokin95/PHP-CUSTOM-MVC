<?php

namespace App\Middleware;

class CheckIfLoggedInMiddleware implements MiddlewareInterface
{
    /**
     * Runs on every request.
     */
    public function handle()
    {
        if (!session('user'))
        {
            redirect('/');
        }
    }
}