<?php

namespace backend\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\form\Login;
use yii\web\Response;
use ZipArchive;

/**
 * SiteController точка входа в админку
 *
 * @package backend\controllers
 */
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Сброс кэша
     *
     * @return Response
     */
    public function actionCache()
    {
        Yii::$app->cacheFrontend->flush();
        Yii::$app->cache->flush();
        Yii::$app->session->setFlash('success', 'Кеш успешно очищен');

        return $this->redirect(['site/index']);
    }

    /**
     * Главная страница
     *
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }
}