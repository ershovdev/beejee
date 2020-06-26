<?php

use Core\App;

session_start();

require_once '../bootstrap.php';

$app = new App();

$app->make($entityManager);
$app->process();
