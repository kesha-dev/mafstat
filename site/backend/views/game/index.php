<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Игры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'date',
            'num',
            'resultName',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'buttonOptions' => [
                    'data-toggle' => 'tooltip',
                    'class' => 'btn btn-default'
                ],
                'headerOptions' => [
                    'style' => 'width:150px;'
                ],
            ],
        ],
    ]); ?>
</div>