<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserCollection */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

//yii\helpers\VarDumper::dump($model->getUserCollectionImage()->asArray()->all(), 10, true);
//die;
?>
<div class="user-collection-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>
    <div class="row">
        <?php
        foreach ($model->getUserCollectionImage()->asArray()->limit(10)->all() as $k => $v):
            $imgs[] = '/userimages/' . $v['image_file'];
            ?>
            <div class="card " style="width:200px; margin:10px 0 0 10px" onclick="currentSlide(<?= $k + 1 ?>)">
                <img class="card-img-top islb-modal-demo" src="/userimages/<?= $v['image_file'] ?>" alt="<?= $v['title'] ?>">
                <div class="card-body">
                    <p class="card-text"><?= $v['title'] ?></p>
                </div>
            </div>
            <?php
        endforeach;
        echo common\widgets\imageSliderLightbox\ImageSliderLightbox::widget(['images' => $imgs]);
        ?>

    </div>
</div>
