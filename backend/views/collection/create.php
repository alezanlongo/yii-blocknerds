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
$fieldId = Html::getInputId($model, 'collection');
$this->registerCss(<<<CSS
            ul.thumbnails {
        overflow: hidden;
        list-style-image: none;
        list-style-position: outside;
        list-style-type: none;
        padding: 0px;
        margin: 0px; }
        ul.thumbnails li {
        margin: 0px 12px 12px 0px;
        overflow: hidden;
        width: 200px;
        height: 265px;
        float: left; }
        ul.thumbnails li img{
        width: 200px;
        height: 255px;
        }
        ul.thumbnails li .thumbnail {
        padding: 6px;
        border: 1px solid #DDD;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none; }

        ul.thumbnails li .thumbnail img {
        -webkit-user-drag: none; }
        ul.thumbnails li:hover {
        background: #08C; }
        ul.thumbnails.selected {
        background-color: #f5f5f5;
        border: 1px #e3e3e3;
        min-height: 200px;
        padding: 10px;
        }
        CSS
);
$this->registerJs(<<<JS
       
              $("#sch-img").on('click',function(e){
        var keyword = $(e.target).prev("input").val()
        $.ajax({
        JS .
        'url:"' . \yii\helpers\Url::to(['collection/lookup']) . '",' .
        <<<JS
        method: "post",
        data: {keyword: keyword},
        success: function(res){
           $("#imgp").empty();
           for(var r of res.img.results){
              $("#imgp").append('<li class="thumbnail"><img src="'+r.thumb+'" /></li>')
           }
               $("#imgp li.thumbnail").off('click')
               $("#imgp li.thumbnail").on('click',function(e){bindAdd(e)})
        },
        error: function(err){alert('error: '+err.responseText)}
        });
        function bindAdd(e){
            $(e.currentTarget).detach().appendTo('#imgp-selected')
        }
   })    
JS, View::POS_READY);
?>
<div class="user-collection-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-12">
        <div class="form-group" style="padding: 10px; display: inline-block; width: 100%">
            <label>Image Search</label>
            <input type="text" name="search" />
            <button type="submit" class="btn btn-success" id="sch-img">search</button>
        </div>
        <div class="content picker">
            <ul class="thumbnails" id="imgp">
            </ul>
        </div>
        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>
    </div>
