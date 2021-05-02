<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\UserCollectionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-collection-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'collection')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
