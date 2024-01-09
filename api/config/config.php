<?php

$files = array_merge(
    glob(__DIR__ . '/common/*.php') ?: [],
    glob(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php') ?: []
);

$configs = [];

foreach ($files as $file) {
    $configs[] = require_once $file;
}

return array_merge_recursive(...$configs);
