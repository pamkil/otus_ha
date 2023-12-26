<?php

namespace api\modules\v1;

/**
 * @OA\OpenApi(
 * 		@OA\Info(
 *          title="Rest api otus_ha",
 *          description="REST API",
 *          version="1.0",
 *          @OA\Contact(email="pamkil@ya.ru"),
 *      ),
 *
 *     @OA\Server(
 *         description="Api server",
 *         url=API_HOST_SWAGGER,
 *     ),
 * ),
 * @OA\Schema(
 *      schema="ErrorModel",
 *      title="Сообщение об ошибке",
 *      required={"code", "message"},
 *      @OA\Property(
 *          property="code",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string"
 *      )
 *  ),
 * @OA\SecurityScheme(
 *      securityScheme="BearerAuth",
 *      type="apiKey",
 *      in="header",
 *      name="Authorization",
 *  )
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'api\modules\v1\controllers';

    public function init()
    {
        define("API_HOST_SWAGGER", '/v1/');
        parent::init();
        \Yii::$app->user->enableSession = false;
    }
}
