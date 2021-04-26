<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=pgsql;dbname=test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'redis',
            'port' => 6379,
            'database' => 0,
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
//            //'class' => 'yii\caching\FileCache',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ],
        ],
    ]
];
