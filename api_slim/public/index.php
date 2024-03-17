<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require_once __DIR__ . '/../config/container.php';

/** @var App $app */
$app = (require_once __DIR__ . '/../config/app_bootstrap.php')($container);

$app->run();
