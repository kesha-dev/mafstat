<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Класс SiteController работы с основными страницами сайта
 * @package frontend\controllers
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
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Главная страница
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {

        return $this->render('index', [
        ]);
    }
}