<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = ['label' => 'Короткие ссылки', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
]); ?>
