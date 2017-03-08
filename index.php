<?php

use lib\Application;

require_once __DIR__ . '/scripts/lib/SplClassLoader.php';

echo "Page index ok";

/*
 *  Definie le chargement des namespaces
 */
$libLoader = new SplClassLoader('lib', __DIR__ . '/scripts');
$libLoader->register();
$modelesLoader = new SplClassLoader('modeles', __DIR__ . '/scripts');
$modelesLoader->register();
$controllerLoader = new SplClassLoader('controllers', __DIR__ . '/scripts');
$controllerLoader->register();

$app = Application::getInstance();
$app->run();