<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\grid\GridView;
use shortener\models\Link;
use yii\helpers\Url;

$this->title = 'Короткие ссылки';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title) ?></h1>
<p><?= Html::a('Создать новую ссылку', ['/link/create'], ['class' => 'btn btn-lg btn-success']) ?></p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'url',
            'label' => 'Урл',
        ],
        [
            'attribute' => 'counter',
            'label' => 'Кол-во переходов',
        ],
        [
            'label' => 'Короткая ссылка',
            'value' => function (Link $model) {
                return Url::to('@web/visit/'.$model->hash, true);
            },
        ],
        [
            'attribute' => 'expiration',
            'label' => 'Дата окончания',
            'value' => function (Link $model) {
                return $model->expiration ?: 'Бессрочно';
            },
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
        ],
    ],
]); ?>
