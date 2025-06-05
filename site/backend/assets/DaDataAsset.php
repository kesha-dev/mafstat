<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Ресурсы, используемые для работы с сервисом DaData.ru
 *
 * Class DaDataAsset
 * @package backend\assets
 */
class DaDataAsset extends AssetBundle
{
    /**
     * @var string базовый путь к файлам
     */
    public $basePath = '@webroot';
    /**
     * @var string базовый url
     */
    public $baseUrl = '@web';
    /**
     * @var array подключенные css ресурсы
     */
    public $css = [
        '//dadata.ru/static/css/lib/suggestions-15.6.css'
    ];
    /**
     * @var array подключенные js ресурсы
     */
    public $js = [
        '//cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js',
        '//dadata.ru/static/js/lib/jquery.suggestions-15.6.min.js'
    ];
    /**
     * @var array зависимости админки
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
