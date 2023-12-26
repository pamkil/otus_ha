<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => yii\rbac\DbManager::class,
            'defaultRoles' => ['guest'],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'maskVars' => [
                        '_SERVER.Authorization',
                        '_SERVER.HTTP_AUTHORIZATION',
                        '_SERVER.PHP_AUTH_USER',
                        '_SERVER.PHP_AUTH_PW',
                        'BODY.refresh_token',
                        'BODY.password',
                    ],
                ],
            ],
        ],
        'cache' => [
            'class' => yii\caching\DummyCache::class,
        ],
        'formatter' => [
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
        ],
    ],
];
