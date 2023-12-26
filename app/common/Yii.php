<?php

use common\modules\queue\Queue;
use common\notification\NotificationService;

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
 * @property \yii\authclient\Collection $authClientCollection
 * @property \yii\db\Connection $dbCc The database connection. This property is read-only.
 * @property \yii\web\UrlManager $urlManagerBackend
 * @property NotificationService $notification
 * @property Queue $queue
 */
abstract class BaseApplication extends yii\base\Application
{
}

