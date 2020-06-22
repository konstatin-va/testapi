<?php

return [
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