<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\GamePlayerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Game Players';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-player-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Game Player', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'player_id',
            'game_id',
            'result_string',
            'penalty_string',
            //'role',
            //'pu',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
