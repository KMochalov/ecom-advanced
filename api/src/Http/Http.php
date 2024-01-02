<?php

namespace App\Http;

use Psr\Http\Message\ResponseInterface as Response;

class Http
{
    public static function json(Response $response, mixed $data): Response
    {
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR, 512));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
