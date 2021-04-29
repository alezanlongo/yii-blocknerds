<?php

use common\models\UserCollection;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

/* @var $this View */
/* @var $model UserCollection */


$this->title = 'Create User Collection';
$this->params['breadcrumbs'][] = ['label' => 'User Collections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$collectionFieldId = Html::getInputId($model, 'collection');
$this->render('_collectionSnippet', ['collectionFieldId' => $collectionFieldId]);
?>
<div class="user-collection-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-12">
        <div class="form-group" style="padding: 10px; display: inline-block; width: 100%">
            <label>Image Search</label>
            <input type="text" name="search" />
            <button type="submit" class="btn btn-success" id="sch-img">search</button>
        </div>
        <div class="content">
            <ul class="thumbnails" id="imgp">
            </ul>
        </div>
    </div>
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
