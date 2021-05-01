<?php

use yii\helpers\Url;
use yii\web\View;

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
        height: 389px;
        float: left; }
        ul.thumbnails li img{
        width: 198px;
        height: 253px;
        }
        ul.thumbnails li:hover{cursor:pointer;}
        ul.thumbnails li .thumbnail {
        padding: 6px;}

        ul.thumbnails li .thumbnail img {
        -webkit-user-drag: none; }
        ul.thumbnails li .card:hover {
        border-color: #08C; }
        ul.thumbnails li .card .card-text {
        padding: 0 10px 0 10px; }
       
        ul.thumbnails li .card{height:387px; overflow:hidden}
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
            if($("#imgp-selected")[0].children.length==0){ $("#$collectionFieldId").val(''); return false;}
            var arr = [];
            for(let elm of $("#imgp-selected")[0].children){
               arr.push($(elm).data('obj'))
               $("#$collectionFieldId").val(JSON.stringify(arr).replace(/'/g, "\\'"))
            }
        }
        function createLiElement(obj){
           return '<li data-obj=\''+JSON.stringify(obj).replace(/'/g, "\\'")+'\' class="thumbnail"><div class="card" style="width: 200px;"><img src="'+obj.thumb+'" class="card-img-top" alt="'+obj.alt_description+'"><h5 class="card-title"></h5><p class="card-text">'+obj.alt_description+'</p></div></div>   </li>';
        }
        
        $(document).ready(function(){
            if($("#$collectionFieldId").val()==''){
                return;
            }
        
            let data = JSON.parse($("#$collectionFieldId").val());
            for(let r of data){
              $("#imgp-selected").append(createLiElement(r))
            }
            $("#imgp-selected li.thumbnail").on('click',function(e){bindAdd(e)})
        });
JS, View::POS_READY);
