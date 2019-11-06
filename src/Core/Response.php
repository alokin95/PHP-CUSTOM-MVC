<?php


namespace App\Core;


class Response
{
    public function json($data = [], $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode([
            'data'      => $data,
            'status'    => $statusCode
        ]);
    }

    public function render($view, $data = [])
    {
        extract($data);
        return require __DIR__.'/../../templates/'.$view;
    }
}