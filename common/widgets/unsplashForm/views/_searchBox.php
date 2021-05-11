<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->registerJs(<<<JS
       
              $("#sch-img").on('click',function(e){
              e.preventDefault();
        var keyword = $('input[name="search"]').val()
        $.ajax({
        JS .
        'url:"' . Url::to(['collection/lookup']) . '",' .
        <<<JS
        method: "post",
        data: {keyword: keyword},
        success: function(res){
           $("#imgp").empty();
           for(var r of res.img.results){
              $("#imgp").append(createLiElement(r))
           }
               $("#imgp li.thumbnail").off('click')
               $("#imgp li.thumbnail").on('click',function(e){bindAdd(e)})
        },
        error: function(err){alert('error: '+err.responseText)}
        });
        })   
        function bindAdd(e){
            var target = e.currentTarget.parentElement.id=='imgp-selected'?'#imgp':'#imgp-selected';
            //console.log($(e.currentTarget).data('obj').id)
            $(e.currentTarget).detach().appendTo(target)
            pushElementsObj();
        }
        function pushElementsObj(){
            if($("#imgp-selected")[0].children.length==0){ $("#$formFieldId").val(''); return false;}
            var arr = [];
            for(let elm of $("#imgp-selected")[0].children){
               arr.push($(elm).data('obj'))
               $("#$formFieldId").val(JSON.stringify(arr).replace(/'/g, ""))
            }
        }
        function createLiElement(obj){
           return '<li data-obj=\''+JSON.stringify(obj).replace(/'/g, "")+'\' class="thumbnail"><div class="card" style="width: 200px;"><img src="'+obj.thumb+'" class="card-img-top" alt="'+obj.alt_description+'"><h5 class="card-title"></h5><p class="card-text">'+obj.alt_description+'</p></div></div>   </li>';
        }
        
        $(document).ready(function(){
            if($("#$formFieldId").val()==''){
                return;
            }
        
            let data = JSON.parse($("#$formFieldId").val());
            for(let r of data){
              $("#imgp-selected").append(createLiElement(r))
            }
            $("#imgp-selected li.thumbnail").on('click',function(e){bindAdd(e)})
        });
JS, View::POS_READY);
?>


<div class="col-12">
    <?php $form = ActiveForm::begin(['options' => ['id' => 'unsplash-search-form']]); ?>
    <div class="form-group" style="padding: 10px; display: inline-block; width: 100%">
        <label>Image Search</label>
        <input type="text" name="search" />
        <button type="submit" class="btn btn-success" id="sch-img">search</button>
    </div>
    <?php $form = ActiveForm::end(); ?>
    <div class="content">
        <ul class="thumbnails" id="imgp">
        </ul>
    </div>
    <div class="form-group">
        <h1>Selected images</h1>
        <ul class="thumbnails selected" id="imgp-selected">
        </ul>
    </div>
</div>