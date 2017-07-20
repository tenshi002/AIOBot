<?php

use lib\Application;
use lib\Autoloader;

require_once __DIR__ . '/scripts/lib/Autoloader.php';

//echo "Page index ok";

/*
 *  Definie le chargement des namespaces
 */

Autoloader::register();

$app = Application::getInstance();
$app->run();