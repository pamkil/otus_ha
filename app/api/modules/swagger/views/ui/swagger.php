<?php

use api\modules\swagger\assets\SwaggerDarkUiAsset;
use api\modules\swagger\assets\SwaggerUiAsset;

/* @var $content string */
SwaggerUiAsset::register($this);
SwaggerDarkUiAsset::register($this);
$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head>
    <link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" type="text/css"/>
    <?php
    $this->head(); ?>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
</head>
<body class="swagger-section">
<?php
$this->beginBody(); ?>
<?php
if (YII_DEBUG): ?>
    <div class="swagger-ui">
        <div class="wrapper">
            <div class="col-12">
                <a href="/debug/default/index">show debug page</a>
            </div>
        </div>
    </div>
<?php
endif; ?>

<div id="swagger-ui"></div>
<?php
/**
 * @var string $token
 * @var string $ver
 */
$this->registerJs(
    <<< JS
    var url = '/swagger.json?access-token=$token';
    var token = '$token';

    const ui = SwaggerUIBundle({
        url: url,
        dom_id: '#swagger-ui',
        deepLinking: true,
        docExpansion: 'none',
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        openapi: "3.0.0",
        layout: "StandaloneLayout",
        onComplete: () => {
            ui.preauthorizeApiKey("keycloak", token);
        }
    });
    ui.authActions.preAuthorizeImplicit({
        auth: {
            name: "BearerAuth",
            schema: {
                flow: 'accessCode',
                type: "apiKey",
                name: "Authorization",
                in: "header",
                get: function (key) {
                  return this[key];
                }
            },
            value: 'Bearer ' + token
        },
        token: 'Bearer ' + token,
        isValid: true
    });
    // End Swagger UI call region
    window.ui = ui;
JS,
); ?>

<?php
$this->endBody(); ?>
</body>
</html>
<?php
$this->endPage(); ?>
