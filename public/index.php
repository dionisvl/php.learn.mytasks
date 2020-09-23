<?php
session_start();
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../config.php';

require __DIR__ . '/../App/helpers.php';

require __DIR__ . '/../routes/router.php';