<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GamePlayer */

$this->title = 'Create Game Player';
$this->params['breadcrumbs'][] = ['label' => 'Game Players', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-player-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
