<?php

use Psr\Container\ContainerInterface;
use Slim\App;
use Slim\Factory\AppFactory;

return static function (ContainerInterface $container): App {
    $app = AppFactory::createFromContainer($container);

    (require_once __DIR__ . '/../config/middleWare.php')($app, $container);
    (require_once __DIR__ . '/../config/routes.php')($app);

    return $app;
};