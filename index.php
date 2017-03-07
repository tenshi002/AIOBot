<?php

require_once __DIR__ . '/scripts/lib/SplClassLoader.php';
require_once __DIR__ . '/scripts/lib/Application.php';

echo "Page index ok";

/*
 *  Definie le chargement des namespaces
 */
$appLoader = new SplClassLoader('lib', __DIR__ . '/scripts/lib');
$appLoader = new SplClassLoader('modeles', __DIR__ . '/scripts/modeles');
$appLoader = new SplClassLoader('Zend_Config_Ini', __DIR__ . '/vendor/zendframework');

$appLoader->register();

$app = Application::getInstance();
$app->run();