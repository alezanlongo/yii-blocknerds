<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\redis\Connection',
            'dsn' => 'pgsql:host=pgsql;dbname=test',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
            'enableQueryCache' => true,
            'queryCacheDuration' => 3600,
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
                'database' => 1,
            ],
        ],
        'session' => [
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 2,
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'port' => '1025',
                'host' => 'mail'
            ],
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'unsplashApi' => [
            'class' => '\common\components\UnsplashApiComponent',
        ],
        'imageStorage' => [
            'class' => '\common\components\ImageStorageComponent',
        ],
    ]
];
