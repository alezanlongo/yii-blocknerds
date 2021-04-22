<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserCollection */

$this->title = 'Update User Collection: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-collection-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
