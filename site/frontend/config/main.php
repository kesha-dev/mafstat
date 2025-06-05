<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'assetManager' => [
            'bundles' => false,
            'basePath' => '@webroot',
            'baseUrl' => '/',
        ],
        'backendUrlManager' => require Yii::getAlias('@backend/config/urlManager.php'),
        'frontendUrlManager' => require Yii::getAlias('@frontend/config/urlManager.php'),
        'urlManager' => function () {return Yii::$app->get('frontendUrlManager');},
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'timeZone' => 'Etc/GMT-3',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'numberFormatterOptions'=>[
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 0,
            ],
            'nullDisplay' => '(не задано)',
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
        ],
    ],
    'params' => $params,
];
