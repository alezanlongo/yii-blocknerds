<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserCollection */

$this->title = 'Create User Collection';
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-collection-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
