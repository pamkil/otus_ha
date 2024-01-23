<?php

use bizley\jwt\Jwt;
use common\modules\queue\Queue;
use common\notification\NotificationService;
use yii\authclient\Collection;
use yii\db\Connection;
use yii\web\UrlManager;

/**
 * Yii bootstrap file.
 * Used for enhanced IDE code autocompletion.
 */
class Yii extends \yii\BaseYii
{
    /**
     * @var BaseApplication the application instance
     */
    public static $app;
}

/**
 * Class BaseApplication
 * Used for properties that are identical for both WebApplication and ConsoleApplication
 *
 * @property Collection $authClientCollection
 * @property Connection $dbCc The database connection. This property is read-only.
 * @property UrlManager $urlManagerBackend
 * @property Jwt $jwt
 */
abstract class BaseApplication extends yii\base\Application
{
}
