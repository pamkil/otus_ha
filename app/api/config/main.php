<?php

declare(strict_types=1);

use bizley\jwt\Jwt;
use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint\LooseValidAt;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use yii\web\UrlManager;
use yii\web\User;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);
$urlManagerV1Rules = require(__DIR__ . '/../modules/v1/urlManagerV1.php');
$urlManagerSwaggerRules = require(__DIR__ . '/../modules/swagger/urlManagerSwagger.php');

return [
    'id' => 'api.otus_ha',
    'name' => 'otus_ha Rest API',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'api/index',
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => api\modules\v1\Module::class,
        ],
        'swagger' => [
            'basePath' => '@app/modules/swagger',
            'class' => api\modules\swagger\Module::class,
        ],
    ],
    'aliases' => [
        '@api' => dirname(__DIR__, 2) . '/api',
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'api/default/error',
        ],
        'response' => [
            'format' => 'json',
            'formatters' => [
                'json' => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => yii\web\JsonParser::class,
                'multipart/form-data' => yii\web\MultipartFormDataParser::class,
            ],
        ],
        'user' => [
            'class' => User::class,
            'identityClass' => \api\modules\v1\user\models\User::class,
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'urlManager' => [
            'class' => UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => array_merge($urlManagerV1Rules, $urlManagerSwaggerRules),
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
