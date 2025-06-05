<?php

use common\models\Club;
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\PlayerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Игроки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="player-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            [
                'attribute' => 'club_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Editable::widget([
                        'model' => $model,
                        'attribute' => 'club_id',
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'value' => $model->club_id,
                        'data' => Club::getClubList(),
                        'displayValueConfig'=> Club::getClubList(),
                        'formOptions' => [
                            'action' => Url::to(['player/save', 'id' => $model->id])
                        ],
                        'buttonsTemplate' => '{submit}',
                        'options' => [
                            'id' => 'club' . $model->id,
                        ]
                    ]);
                }
            ],
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
