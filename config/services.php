<?php
// config/services.php

// Value objects are used to reference parameters and services in the container
use App\Container\Reference\ParameterReference as PR;
use App\Container\Reference\ServiceReference as SR;

use Monolog\Handler\NativeMailerHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

return [
    StreamHandler::class => [
        'class' => StreamHandler::class,
        'arguments' => [
            new PR('logger.file'),
            Logger::DEBUG,
        ],
    ],
    NativeMailerHandler::class => [
        'class' => NativeMailerHandler::class,
        'arguments' => [
            new PR('logger.mail.to_address'),
            new PR('logger.mail.subject'),
            new PR('logger.mail.from_address'),
            Logger::ERROR,
        ],
    ],
    LoggerInterface::class => [
        'class' => Logger::class,
        'arguments' => ['channel-name'],
        'calls' => [
            [
                'method' => 'pushHandler',
                'arguments' => [
                    new SR(StreamHandler::class),
                ]
            ],
            [
                'method' => 'pushHandler',
                'arguments' => [
                    new SR(NativeMailerHandler::class),
                ]
            ]
        ]
    ]
];