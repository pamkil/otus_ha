<?php

declare(strict_types=1);

namespace api\modules\v1\user\actions;

use api\modules\v1\user\models\LoginForm;
use Exception;
use OpenApi\Annotations as OA;
use Throwable;
use Yii;
use yii\base\Action;
use yii\base\Model;
use yii\web\Response;

class Login extends Action
{
    /**
     * Авторизация
     * @OA\Post(
     *      path="/login",
     *      summary="Login as user. Получение токена по логину и паролю",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          description="Создание пользователья",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginForm")
     *      ),
     *    @OA\Response(
     *        response="200",
     *        description="Объект токена",
     *        @OA\JsonContent(ref="#/components/schemas/LoginForm")
     *    )
     * )
     *
     * @return string|null|Response|Model
     * @throws Exception
     */
    public function run()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->bodyParams, '');

        try {
            if ($token = $model->auth()) {
                return $token;
            }

            return $model;
        } catch (Exception|Throwable $exception) {
            Yii::error($exception);
            $response = Yii::$app->response;
            $response->setStatusCode(401);

            return $response;
        }
    }
}
