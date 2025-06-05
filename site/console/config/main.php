<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'bootstrap' => ['log', 'queue', 'queueFiles'],
    'components' => [
	    'user' => [
		    'class' => ''
	    ],
        'frontendUrlManager' => require Yii::getAlias('@frontend/config/urlManager.php'),
        'backendUrlManager' => require Yii::getAlias('@backend/config/urlManager.php'),
        'urlManager' => function () {
            return Yii::$app->get('frontendUrlManager');
        },
        'cacheFrontend' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => '@frontend/runtime/cache'
        ],
    ],
    'params' => $params,
];
