<?php

$builder = new DI\ContainerBuilder();

$builder->addDefinitions(require_once __DIR__.'/../config/config.php');

return $builder->build();
