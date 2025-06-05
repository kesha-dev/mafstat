<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GamePlayer */

$this->title = 'Update Game Player: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Game Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="game-player-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
