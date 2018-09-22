<?php

/* @var $this yii\web\View */

use yii\bootstrap\Html;

$this->title = 'ShortenerUrl';
?>
<div class="site-index">
    <div class="jumbotron">
        <h1>Yii2 URL Shortener</h1>

        <p class="lead">Сервис для создания коротких ссылок.</p>

        <?php
        if (Yii::$app->user->isGuest) {
            echo Html::a('Вход на сайт', ['/site/login'], ['class' => 'btn btn-lg btn-success']);
        } else {
            echo Html::a('Создать новую ссылку', ['/link/create'], ['class' => 'btn btn-lg btn-success']);
        }
        ?>

    </div>
</div>
