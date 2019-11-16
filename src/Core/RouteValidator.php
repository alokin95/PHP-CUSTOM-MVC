<?php


namespace App\Core;


class RouteValidator
{
    public function validateRoute($route)
    {
        try
        {
            $route = trim($route, '/');

            if ($route === '')
            {
                return true;
            }

            $allowedUrlFormat = "/^([A-z0-9]{1,}|\{[A-z]{1,}\})(\/[A-z0-9]{1,}|\/\{[A-z]{1,}\})*([A-z0-9]{1,}|\/\{[A-z]{1,}\})*$/";

            if (!preg_match($allowedUrlFormat, $route))
            {
                throw new ExceptionHandler('Invalid route format');
            }

            if (!$this->checkDuplicateSlugs($route))
            {
                throw new ExceptionHandler('Duplicate slugs not allowed in a route');
            }

            return true;
        }
        catch(ExceptionHandler $e)
        {
            $e->handle();
        }
    }

    private function checkDuplicateSlugs($route)
    {
        $preg = '/\{[A-z]{1,}\}/';
        preg_match_all($preg, $route, $matched);

        $check_duplicate_values = array_count_values($matched[0]);

        foreach ($check_duplicate_values as $duplicate_value)
        {
            if ($duplicate_value > 1)
            {
                return false;
            }
        }

        return true;
    }
}