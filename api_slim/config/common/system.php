<?php

use App\Auth\Repository\UserRepository;
use App\Auth\Repository\UserRepositoryInterface;
use App\Auth\Serivces\Hasher;
use App\Auth\Serivces\HasherInterface;
use App\Auth\Serivces\Sender;
use App\Auth\Serivces\SenderInterface;
use App\Auth\Serivces\Tokenizer;
use App\Auth\Serivces\TokenizerInterface;

return [
    'config' => [
        'debug' =>  (bool) getenv('APP_DEBUG'),
        'env' => getenv('APP_ENV') ?: 'prod',
    ],
    UserRepositoryInterface::class => DI\create(UserRepository::class),
    SenderInterface::class => DI\create(Sender::class),
    TokenizerInterface::class => DI\create(Tokenizer::class),
    HasherInterface::class => DI\create(Hasher::class),
];
