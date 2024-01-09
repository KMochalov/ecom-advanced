<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

require_once __DIR__ . '/../vendor/autoload.php';

$container = require_once __DIR__ . '/../config/container.php';

$cli = new Application('Console');

/** @var string[] $commands
 * @psalm-suppress MixedArrayAccess
 */
$commands = $container->get('config')['console']['commands'];

foreach ($commands as $commandName) {
    /** @var Command $command */
    $command = $container->get($commandName);
    $cli->add($command);
}

$cli->run();
