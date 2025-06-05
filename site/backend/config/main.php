<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ],
    ],
    'components' => [
        'formatter' => [
            'timeZone' => 'Etc/GMT-3',
            'dateFormat' => 'dd.MM.yyyy',
            'datetimeFormat' => 'dd.MM.yyyy HH:mm',
            'locale' => 'ru-RU',
            'defaultTimeZone' => 'Europe/Moscow',
        ],
        'frontendUrlManager' => require Yii::getAlias('@frontend/config/urlManager.php'),
        'backendUrlManager' => require Yii::getAlias('@backend/config/urlManager.php'),
        'urlManager' => function () {return Yii::$app->get('backendUrlManager');},
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'cacheFrontend' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache'
        ],
    ],

    'params' => $params,
];
