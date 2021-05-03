<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserCollectionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//var_dump($dataProvider);
//die;

$this->title = 'User Collections';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-collection-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php // echo Html::a('Create User Collection', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'user.username',
            'created_at:datetime',
            'updated_at:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
