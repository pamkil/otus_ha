<?php

declare(strict_types=1);

use yii\rest\UrlRule;

return [
    'swagger.json' => 'v1/swagger/swagger',

    [
        'class' => UrlRule::class,
        'controller' => [
            'user' => 'v1/user/user',
        ],
        'extraPatterns' => [
            'GET get/{id}' => 'get',
            'OPTIONS get' => 'options',
            'POST register' => 'register',
            'OPTIONS register' => 'options',
        ],
        'tokens' => [
            '{id}' => '<id:[a-f0-9-]{36}>',
        ],
        'pluralize' => false,
    ],
    'POST login' => 'v1/user/user/login',
];
