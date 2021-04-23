<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\UserCollectionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-collection-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'collection')->hiddenInput() ?>
    <div class="form-group">
        <ul class="thumbnails selected" id="imgp-selected">
        </ul>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
