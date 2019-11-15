<?php


namespace App\Middleware;


trait AuthorizesRequests
{
    protected $middleware;

    public function middleware($middleware)
    {
        if (is_array($middleware))
        {
            foreach ($middleware as $m)
            {
                $this->middleware[] = $m;
            }
            return;
        }
        $this->middleware = $middleware;
    }
}