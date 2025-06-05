<?php

namespace console\controllers;

use common\components\importXlsx\ImportXlsx;
use yii\console\Controller;
use yii\helpers\VarDumper;

class ImportXlsxController extends Controller
{
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $path = \Yii::getAlias('@console/runtime/files/import.xlsx');
        $import = new ImportXlsx($path);
        $import->run();
    }
}