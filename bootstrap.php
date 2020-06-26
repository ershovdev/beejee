<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

session_start();

require_once 'vendor/autoload.php';

// Initialization of the Doctrine/ORM
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

$config = Setup::createAnnotationMetadataConfiguration(
    array(__DIR__ . "/src"),
    $isDevMode,
    $proxyDir,
    $cache,
    $useSimpleAnnotationReader
);

$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
);

$entityManager = EntityManager::create($conn, $config);

