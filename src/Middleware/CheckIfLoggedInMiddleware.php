<?php


namespace App\Middleware;


class CheckIfLoggedInMiddleware implements MiddlewareInterface
{

    /**
     * @return bool
     */
    public function handle()
    {
        return true;
    }
}