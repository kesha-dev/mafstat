<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use backend\assets\AppAsset;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon-precomposed" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-196x196.png" sizes="196x196">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/favicon-128.png" sizes="128x128">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#ffffff">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="application-name" content="Backend mafstat"/>
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="msapplication-square70x70logo" content="/mstile-70x70.png">
    <meta name="msapplication-square150x150logo" content="/mstile-150x150.png">
    <meta name="msapplication-wide310x150logo" content="/mstile-310x150.png">
    <meta name="msapplication-square310x310logo" content="/mstile-310x310.png">
    <?php $this->head() ?>
</head>
<body style="overflow-y: scroll">
<?php $this->beginBody() ?>
<?php
NavBar::begin([
    'brandLabel' => 'Сайты',
    'brandUrl' => '/',
    'options' => [
        'class' => 'navbar navbar-default navbar-static-top',
    ],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],

    'items' => [
        [
            'label' => 'Клубы',
            'url' => ['club/index'],
        ],
        [
            'label' => 'Игроки',
            'url' => ['player/index'],
        ],
        [
            'label' => 'Игры',
            'url' => ['/game/index'],
        ],
    ],
]);
NavBar::end();
?>
<div class="section">
    <div class="container-fluid" style="margin-bottom: 30px">
        <div class="row">
            <div class="col-md-12">
                <?php
                echo Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Администрирование',
                        'url' => ['/site/index']
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]);
                $flashes = Yii::$app->session->allFlashes;
                foreach ($flashes as $type => $flash) {
                    echo Alert::widget([
                        'options' => [
                            'class' => 'alert-' . $type,
                        ],
                        'body' => $flash
                    ]);
                }
                ?>
                <?= $content ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>