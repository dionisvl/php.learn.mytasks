<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require 'vendor/autoload.php';

require 'config.php';

require 'App/helpers.php';

require 'routes/router.php';
