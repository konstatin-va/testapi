<?php

namespace App\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

$conn = [
    'driver'   => 'pdo_mysql',
    'host'     => 'mysql',
    'user'     => 'root',
    'password' => 'secret',
    'dbname'   => 'market',
    'charset'  => 'utf8',
    'driverOptions' => [
        1002 => 'SET NAMES utf8'
    ],
];

$entityManager = EntityManager::create($conn, $config);

return $entityManager;
