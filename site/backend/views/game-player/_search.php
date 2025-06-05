<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\GamePlayerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-player-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'player_id') ?>

    <?= $form->field($model, 'game_id') ?>

    <?= $form->field($model, 'result_string') ?>

    <?= $form->field($model, 'penalty_string') ?>

    <?php // echo $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'pu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
