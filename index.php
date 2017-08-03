<?php

session_start();

use lib\Application;
use Zend\Loader\AutoloaderFactory;

define('APPLICATION_PATH', __DIR__);

require_once APPLICATION_PATH . '/vendor/autoload.php';
require_once APPLICATION_PATH . '/configurations/config.php';

AutoloaderFactory::factory($config);

$app = Application::getInstance();
$app->run();


/**
 * DOC
 *
 * Lien icons : https://material.io/icons/
 * Lien CSS : http://fezvrasta.github.io/bootstrap-material-design/bootstrap-elements.html
 * Lien Material : http://fezvrasta.github.io/bootstrap-material-design/
 */