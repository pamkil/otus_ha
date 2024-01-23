<?php

declare(strict_types=1);

namespace api\modules\v1\user;

use api\modules\v1\RestController;
use api\modules\v1\user\actions\Login;
use api\modules\v1\user\actions\Register;
use api\modules\v1\user\actions\View;
use api\modules\v1\user\models\User;
use OpenApi\Annotations as OA;
use yii\helpers\ArrayHelper;
use yii\rest\OptionsAction;

/**
 * @OA\Tag(
 *   name="Auth",
 *   description="login, recovery, refresh"
 * )
 */
class UserController extends RestController
{
    public $modelClass = User::class;

    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'except' => ['options', 'login', 'register', 'get'],
            ],
        ]);
    }

    public function actions(): array
    {
        return [
            'options' => [
                'class' => OptionsAction::class,
            ],
            'login' => [
                'class' => Login::class,
            ],
            'register' => [
                'class' => Register::class,
            ],
            'get' => [
                'class' => View::class,
            ],
        ];
    }

    public function verbs(): array
    {
        return [
            'login' => ['POST'],
            'register' => ['POST'],
            'get' => ['GET'],
        ];
    }
}
