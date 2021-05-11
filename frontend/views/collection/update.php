<?php

use common\models\UserCollection;
use common\widgets\unsplashForm\UnsplashForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model UserCollection */

$this->title = 'Update User Collection: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-collection-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= UnsplashForm::widget(['formFieldId' => Html::getInputId($model, 'collection')]); ?> 
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
