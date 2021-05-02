<?php

use common\models\UserCollection;
use common\widgets\unsplashForm\UnsplashForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model UserCollection */

$this->title = 'Update User Collection: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-collection-update">
    <?= UnsplashForm::widget(['formFieldId' => Html::getInputId($model, 'collection')]); ?> 
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
