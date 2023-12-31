<?php

namespace App\Http;

use Fig\Http\Message\StatusCodeInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Headers;
use Slim\Psr7\Factory\StreamFactory;

class JsonResponse extends Response
{
    public function __construct(mixed $data, int $status = StatusCodeInterface::STATUS_OK)
    {
        parent::__construct(
            $status,
            new Headers(['Content-Type' => 'application/json']),
            (new StreamFactory())->createStream(json_encode($data, JSON_THROW_ON_ERROR, 512))
        );
    }
}
