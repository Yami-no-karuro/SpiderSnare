<?php

use App\Kernel;

error_reporting(0);
define('NO_DIRECT_ACCESS', 'true');

require_once(__DIR__ . '/../src/functions.php');
require_once(__DIR__ . '/../src/constants.php');
require_once(__DIR__ . '/../src/autoload.php');

date_default_timezone_set(DEFAULT_TIMEZONE);

$application = Kernel::bootstrap();
$application->run();
die();
