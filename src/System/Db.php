<?php

namespace App\System;

class Db 
{
    public $params = null;  

    public function __construct()
    {
        $paths = [__DIR__ . '/../Entity'];
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;

        // the connection configuration
        $dbParams = [
            'driver'   => 'pdo_mysql',
            'host'     => 'mysql',
            'user'     => 'root',
            'password' => 'secret',
            'dbname'   => 'testapi',
            'charset'  => 'utf8',
            'driverOptions' => [
                1002 => 'SET NAMES utf8'
            ],
        ];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        $this->em = EntityManager::create($dbParams, $config);
    }

    public function getConnection()
    {
        return $this->em;
    }
}
