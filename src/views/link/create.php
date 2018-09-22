<?php

/* @var $this yii\web\View */

/* @var $model \shortener\forms\CreateUrlForm */

use yii\bootstrap\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$this->title = 'Создать короткую ссылку';
$this->params['breadcrumbs'][] = ['label' => 'Короткие ссылки', 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="link-create container">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="link-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]); ?>

        <?= $form->field($model, 'expiration')->widget(
            DateTimePicker::class, [
            'type' => DateTimePicker::TYPE_INPUT,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd.mm.yyyy hh:ii',
            ],
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton('Создать', ['class' => 'btn btn-success']); ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
