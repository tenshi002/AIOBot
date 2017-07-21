<?php
/**
 * Created by IntelliJ IDEA.
 * User: ssouppaya
 * Date: 17/02/17
 * Time: 15:44
 */


use Doctrine\ORM\Tools\Console\ConsoleRunner;
use lib\Application;

// replace with file to your own project bootstrap
//require_once 'bootstrap.php';

require_once __DIR__ . '/../scripts/lib/Application.php';
require_once __DIR__ . '/../scripts/lib/Configuration.php';


$app = Application::getInstance();

// replace with mechanism to retrieve EntityManager in your app
$application = new Application();
$entityManager = $application->getEntityManager();

return ConsoleRunner::createHelperSet($entityManager);
