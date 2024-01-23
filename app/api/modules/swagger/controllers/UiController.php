<?php

namespace api\modules\swagger\controllers;

use api\modules\v1\models\records\auth\User;
use common\models\access\Token;
use Yii;
use yii\web\Controller;

class UiController extends Controller
{
    /**
     * @return string
     */
    public function actionSwagger()
    {
        Yii::$app->response->format = 'html';
        $this->layout = false;
        $token = null;

        return $this->render(
            'swagger',
            [
                'token' => (string)$token,
            ],
        );
    }
}
