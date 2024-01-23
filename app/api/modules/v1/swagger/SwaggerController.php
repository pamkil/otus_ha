<?php

declare(strict_types=1);

namespace api\modules\v1\swagger;

use api\modules\v1\RestController;
use Yii;
use yii\helpers\ArrayHelper;

use function OpenApi\scan;

class SwaggerController extends RestController
{
    public function behaviors(): array
    {
        $behaviors = ArrayHelper::merge(
            parent::behaviors(),
            [
                'authenticator' => [
                    'except' => ['index', 'options'],
                ],
            ],
        );


        return $behaviors;
    }

    /**
     * @return array
     */
    public function actions(): array
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $token = 'test';

        Yii::$app->response->headers->set('content-type', 'application/json');
        Yii::$app->response->headers->set('Authorization', "Bearer $token");
        Yii::$app->response->format = 'json';

        $openapi = scan(Yii::getAlias('@api/modules/v1'));

        return json_decode($openapi->toJson(JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }
}
