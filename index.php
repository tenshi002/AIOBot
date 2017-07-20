<?php

use lib\Application;
use lib\Autoloader;

require_once __DIR__ . '/scripts/lib/Autoloader.php';
require_once __DIR__ . '/vendor/autoload.php';

Autoloader::register();

$app = Application::getInstance();
$app->run();
