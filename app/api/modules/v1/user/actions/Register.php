<?php

declare(strict_types=1);

namespace api\modules\v1\user\actions;

use api\modules\v1\user\models\RegisterForm;
use Exception;
use OpenApi\Annotations as OA;
use Yii;
use yii\base\Action;

class Register extends Action
{
    /**
     * @OA\Post(
     *      path="/user/register",
     *      summary="Register new user. Регистрация нового пользователя",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          description="Создание пользователья",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterForm")
     *      ),
     *      @OA\Response(
     *        response="200",
     *        description="Объект ид пользователя",
     *        @OA\JsonContent(
     *              @OA\Property(
     *                  property="user_id",
     *                  type="string",
     *                  format="uuid",
     *                  description="",
     *              ),
     *          )
     *      )
     * )
     *
     * @return RegisterForm|string
     * @throws Exception
     */
    public function run()
    {
        $data = Yii::$app->request->bodyParams;
        $model = new RegisterForm();
        $model->load($data, '');

        if ($model->validate() && $userId = $model->createUser()) {
            return ['user_id' => $userId];
        }

        return $model;
    }
}
