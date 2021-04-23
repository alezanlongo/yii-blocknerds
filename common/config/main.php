<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => 'redis',
                'port' => 6379,
                'database' => 0,
            ],
//        'cache' => [
//            //'class' => 'yii\caching\FileCache',
//            'class' => 'yii\redis\Cache',
        ],
        'unsplashApi' => [
            'class' => 'app\components\UnsplashApi',
        ],
    ]
];
