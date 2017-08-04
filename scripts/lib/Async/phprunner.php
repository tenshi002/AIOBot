<?php

namespace lib\Async;

use models\Constante;
use Utils;

// this script = $argv[0]
$runnableFileName = $argv[1];
$contextFileName = $argv[2];
$applicationPath = $argv[3];

//ini_set('error_log', Utils::getPath('LOG') .'/phptask_error.log');

$serializedRunnable = file_get_contents($contextFileName);

require_once $runnableFileName;
$runnable = unserialize($serializedRunnable);

unset($serializedRunnable);

$runnable->confirmStartup();
//error_log(print_r($runnable, true));
$runnable->run();

?>
