<?php

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../config/container.php';

$cli = new Application('Console');

$commands = $container->get('config')['console']['commands'];

foreach ($commands as $command) {
    $cli->add($container->get($command));
}

$cli->run();
