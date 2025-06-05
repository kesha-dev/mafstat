<?php


return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontend'],
    'baseUrl' => $params['frontend'],
    'scriptUrl' => $params['frontend'],
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
    ]
];