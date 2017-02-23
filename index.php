<?php

require_once __DIR__ . '/scripts/lib/SplClassLoader.php';

echo "Page index ok";

/*
 *  Definie le chargement des namespaces
 */
$appLoader = new SplClassLoader('lib', __DIR__ . '/scripts/lib');
$appLoader = new SplClassLoader('modeles', __DIR__ . '/scripts/modeles');

$appLoader->register();

$app = new Application();
$app->run();