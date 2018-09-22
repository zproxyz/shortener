<?php

/* @var $this yii\web\View */

/* @var $model \shortener\models\Link */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$this->title = 'Редактирование ссылки';
$this->params['breadcrumbs'][] = ['label' => 'Короткие ссылки', 'url' => ['list']];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= $model->url ?></p>

    <div class="link-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'expiration')->widget(
            DateTimePicker::class, [
            'type' => DateTimePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy hh:ii',
            ],
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
