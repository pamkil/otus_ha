<?php

use bizley\jwt\Jwt;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'templateFile' => '@console/migrations/templates/uuid.php',
        ],
    ],
    'components' => [
        'log' => [
            'flushInterval' => 1,
        ],
        'jwt' => [
            'class' => Jwt::class,
            'signer' => Jwt::RS256,
            'signingKey' => '@api/runtime/jwtRS256.key',
            'verifyingKey' => '@api/runtime/jwtRS256.key.pub',
            'validationConstraints' => [
                [
                    function () {
                        return Yii::createObject(LooseValidAt::class, [
                            'clock' => SystemClock::fromUTC(),
                        ]);
                    },
                ],
                [
                    function () {
                        $builder = Yii::$app->jwt->getConfiguration();
                        return Yii::createObject(SignedWith::class, [
                            'signer' => $builder->signer(),
                            'key' => $builder->verificationKey(),
                        ]);
                    },
                ],
            ],
        ],
    ],
    'params' => $params,
];
