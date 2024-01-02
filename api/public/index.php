<?php

declare(strict_types = 1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require_once __DIR__.'/../config/container.php';

$app = AppFactory::createFromContainer($container);

(require_once __DIR__.'/../config/middleWare.php')($app, $container);
(require_once __DIR__.'/../config/routes.php')($app);

$app->run();
