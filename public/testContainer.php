<?php // app/file.php

use Psr\Log\LoggerInterface;

require_once __DIR__.'/../vendor/autoload.php';

$container = include __DIR__.'/../config/container.php';

$logger = $container->get(LoggerInterface::class);
$logger->debug('This will be logged to the file');
$logger->error('This will be logged to the file and the email');
echo 'Well done! now see app.log file in project directory.';