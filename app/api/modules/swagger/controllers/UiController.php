<?php

namespace api\modules\swagger\controllers;

use api\modules\v1\models\records\auth\User;
use common\models\access\Token;
use Yii;
use yii\web\Controller;

class UiController extends Controller
{
    /**
     * @param null $id
     * @param string $ver is: v1
     *
     * @return string
     */
    public function actionSwagger($id = null, string $ver = 'v1')
    {
        Yii::$app->response->format = 'html';
        $this->layout = false;
        $token = null;

        return $this->render(
            'swagger',
            [
                'token' => (string)$token,
                'ver' => $ver,
            ]
        );
    }
}
