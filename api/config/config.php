<?php

$files = array_merge(
    glob(__DIR__ . '/common/*.php') ?: [],
    glob(__DIR__ . '/' . (getenv('APP_ENV') ?: 'prod') . '/*.php') ?: []
);

$configs = [];

/** @var string $file */
foreach ($files as $file) {
    if (is_file($file)) {
        $configs[] = (array) require_once $file;
    }
}

return array_merge_recursive(...$configs);
