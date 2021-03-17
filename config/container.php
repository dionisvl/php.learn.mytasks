<?php
// config/container.php

use App\Container\Container;

$services = include __DIR__ . '/services.php';
$parameters = include __DIR__ . '/parameters.php';

return new Container($services, $parameters);