<?php
session_start();
// Report simple running errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require 'vendor/autoload.php';

require 'config.php';

require 'App/helpers.php';

require 'routes/router.php';


//dd('end of script');
