<?php

use common\notification\NotificationService;

return [
    'components' => [
        'db' => [
            'class' => yii\db\Connection::class,
            'dsn' => 'pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT')
                . ';dbname=' . getenv('DB_NAME') . ';application_name=web_dev',
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
    ],
];
