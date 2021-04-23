<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserCollection */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-collection-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'collection')->hiddenInput() ?>
    <div class="form-group">
        <ul class="thumbnails selected" id="imgp-selected">
        </ul>
    </div>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
