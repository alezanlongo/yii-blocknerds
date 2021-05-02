<?php

use common\models\UserCollection;
use common\widgets\unsplashForm\UnsplashForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model UserCollection */


$this->title = 'Create User Collection';
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= UnsplashForm::widget(['formFieldId' => Html::getInputId($model, 'collection')]); ?> 
<?=
$this->render('_form', [
    'model' => $model,
])
?>
</div>
