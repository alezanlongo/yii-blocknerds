<?php

use common\models\UserCollection;
use yii\bootstrap4\Html;
use yii\web\View;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this View */
/* @var $model UserCollection */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
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
                    if (empty($data)) {
                        return 'No images selected';
                    };
                    $thumbs = '';
                    foreach ($data->getUserCollectionImage()->all() as $v) {
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
