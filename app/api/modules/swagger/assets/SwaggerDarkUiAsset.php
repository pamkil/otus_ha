<?php
namespace api\modules\swagger\assets;

use yii\web\AssetBundle;

class SwaggerDarkUiAsset extends AssetBundle
{
    public $sourcePath = '@api/modules/swagger/assets/';

    public $css = [
        'swagger-dark.css',
//        'swagger-dark.user.css'
    ];
}
