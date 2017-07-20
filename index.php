<?php

use lib\Application;
use lib\Autoloader;

require_once __DIR__ . '/scripts/lib/Autoloader.php';

Autoloader::register();

$app = Application::getInstance();
$app->run();