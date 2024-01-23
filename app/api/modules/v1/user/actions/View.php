<?php

declare(strict_types=1);

namespace api\modules\v1\user\actions;

use api\modules\v1\user\models\User;
use common\helpers\Creator;
use Exception;
use OpenApi\Annotations as OA;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;

class View extends Action
{
    /**
     * @OA\Get(
     *      path="/user/get/{id}",
     *      summary="Получение анкеты пользователя",
     *      tags={"Auth"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="id",
     *          required=true,
     *          @OA\Schema(
     *              type="string",
     *              format="uuid"
     *          )
     *      ),
     *      @OA\Response(
     *        response="200",
     *        description="Объект ид пользователя",
     *        @OA\JsonContent(ref="#/components/schemas/User")
     *      )
     * )
     *
     * @throws Exception
     */
    public function run($id)
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException('Не верный идентификатор');
        }

        $row = Yii::$app->db->createCommand(
            <<<SQL
                select * from "user" where "id" = :id
            SQL,
            [':id' => $id],
        )
            ->queryOne();

        if (!$row) {
            throw new NotFoundHttpException();
        }

        return Creator::createModel(new User(), $row);
    }
}
