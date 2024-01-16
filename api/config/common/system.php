<?php

return [
    'config' => [
        'debug' =>  (bool) getenv('APP_DEBUG'),
        'env' => getenv('APP_ENV') ?: 'prod',
    ],
];
