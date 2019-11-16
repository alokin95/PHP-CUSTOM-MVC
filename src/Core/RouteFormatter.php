<?php


namespace App\Core;


class RouteFormatter
{
    public function matchRoute($route, $uri)
    {
        $initialRoute = explode('/', trim($route,'/'));

        $route = $this->replaceSlugsWithRegex($route);

        $uri = explode('/', trim($uri, '/'));

        if (count($uri) !== count($route))
        {
            return false;
        }

        foreach ($uri as $key => $item)
        {
            if ($route[$key] === '/(.*)+/')
            {
                if (!preg_match($route[$key], $item))
                {
                    return false;
                }
            }

            if ($route[$key] !== '/(.*)+/')
            {
                if ($item !== $route[$key])
                {
                    return false;
                }
            }
        }

        return $this->extractDynamicParameters($initialRoute, $uri);
    }

    private function replaceSlugsWithRegex($route)
    {
        $createRegex = "/\{[A-z]{1,}\}/";
        $array = explode('/', trim($route,'/'));
        $route = [];
        foreach ($array as $el)
        {
            $route[] = preg_replace($createRegex, "/(.*)+/", $el);
        }

        return $route;
    }

    private function extractDynamicParameters(array $initialRoute, array $uri)
    {
        $methodParameters = [];
        foreach($initialRoute as $key => $param)
        {
            if (strpos($param, '}'))
            {
                $methodParameters[] = $uri[$key];
            }
        }

        return $methodParameters;
    }
}