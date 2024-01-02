<?php

declare(strict_types = 1);

use Slim\Factory\AppFactory;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(
    [
        'config' => [
            'debug' =>  (bool) getenv('APP_DEBUG')
        ]
    ]
);

$container = $builder->build();

$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware($container->get('config')['debug'], true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    throw new DomainException();
    $response->getBody()->write('{"test":"test"}');
    return $response->withHeader('Content-Type','application/json');
});

$app->run();
