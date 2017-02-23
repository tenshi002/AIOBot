<?php

require_once __DIR__ . '/scripts/lib/SplClassLoader.php';


//$test = $_GET['viewer'];
//echo '!kiss ' . $test;
//echo json_encode(array('moi'=>$test));

echo "Page index ok";

$appLoader = new SplClassLoader('lib', __DIR__ . '/scripts/lib');

$appLoader->register();

$app = new Application();
$app->