<?php
// config/parameters.php

return [
    'logger' => [
        'file' => __DIR__ . '/../app.log',
        'mail' => [
            'to_address' => 'webmaster@domain.com',
            'from_address' => 'alerts@domain.com',
            'subject' => 'App Logs',
        ],
    ],
];