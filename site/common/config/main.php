<?php

use aquy\setting\Setting;
use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

$statics = require Yii::getAlias('@common/config/params-local.php');
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru',
    'sourceLanguage' => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Etc/GMT-3',
    'bootstrap' => ['thumbnail'],
    'components' => [
        'setting' => [
            'class' => Setting::class
        ],
        'thumbnail' => [
            'class' => 'aquy\thumbnail\ThumbnailConfig',
            'cashBaseAlias' => '@statics',
            'cashWebAlias' => $statics['statics'],
            'cacheAlias' => 'thumbnails',
            'quality' => 92,
            'webpQuality' => 90,
            'color' => ['#fff', 0]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'queue' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => MysqlMutex::class,
            'ttr' => 36000,
        ],
        'queueFiles' => [
            'class' => Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'files',
            'mutex' => MysqlMutex::class,
            'ttr' => 36000,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'httpOnly' => true,
                'domain' => '.' . $statics['domain'],
            ],
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => [
                'httpOnly' => true,
                'domain' => '.' . $statics['domain'],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => [
                'moder',
                'admin',
            ],
            'itemFile' => '@backend/config/rbac/data/items.php',
            'assignmentFile' => '@backend/config/rbac/data/assignments.php',
            'ruleFile' => '@backend/config/rbac/data/rules.php',
        ],
    ],
];

