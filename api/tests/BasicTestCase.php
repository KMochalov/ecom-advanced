<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ServerRequestFactory;
use Slim\App;

class BasicTestCase extends TestCase
{
    protected static function json(string $method, string $path): ServerRequestInterface
    {
        return self::request($method, $path)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Accept', 'application/json');
    }

    protected static function request(string $method, string $path): ServerRequestInterface
    {
        return (new ServerRequestFactory())->createServerRequest($method, $path);
    }

    protected function app(): App
    {
        /** @var ContainerInterface $container */
        $container = require_once __DIR__ . '/../config/container.php';

        /** @var App $app */
        $app = (require_once __DIR__ . '/../config/app_bootstrap.php')($container);

        return $app;
    }
}
