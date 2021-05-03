<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserCollection */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
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

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'attribute' => 'collection',
                'format' => 'raw',
                'value' => function ($data) {
                    if($data->getUserCollectionImage()->count()==0){return 'No images selected';};
                    $imgs = $data->getUserCollectionImage()->all();
                    $thumbs = '';
                    foreach ($imgs as $v) {
                        $thumbs .= "<li><img src=\"/userimages/{$v['image_file']}\"></li>";
                    }
                    return '<ul class="widgetview">' . $thumbs . '</ul>';
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ])
    ?>

</div>