<?php

use common\widgets\imageSlider\ImageSlider;
use yii\helpers\Url;
use yii\web\View;
use yii\bootstrap4\BootstrapAsset;

/* @var $this View */

$this->title = 'My Yii Application';
$this->registerJs(<<<JS
            var isDownloading = false;
            $(".download-collection").on("click",function(e){
            e.preventDefault()
            if(isDownloading==true){return false;}
            isDownloading = true;
            let id = e.currentTarget.id.match(/^collection\-([0-9]+)/)[1]
            $('#'+e.currentTarget.id).append(' <i class="spinner-border spinner-border-sm"></i>');
            $.ajax({
            JS .
        'url:"' . Url::to(['site/download']) . '/?id="+id,' .
        'success: function(res){ $("i","#"+e.currentTarget.id).remove(); isDownloading=false;location.href="' . Url::to(['site/download']) . '?id="+id+"&token="+res.download_token+"";},' .
        <<<JS
             error: function(err){ $("i","#"+e.currentTarget.id).remove(); isDownloading = false; alert('error: '+err.responseText)}
            })
        })
        
        JS, View::POS_READY);
?>

<div class="site-index">

    <div class="jumbotron">
        <h1>Collections</h1>
        <p><?php if (empty($collections)): ?>You haven't a collections yet!<?php else: ?>Showing <?= count($collections); ?> collections!<?php endif ?></p>
    </div>
    <div class="body-content">
        <div class="row">

            <?php
            if (!empty($collections)):
                foreach ($collections as $vCollection):
                    ?>
                    <div class="col-lg-4">
                        <?php
                        $images = [];
                        foreach ($vCollection->getUserCollectionImage()->all() as $vImages) {
                            $images[] = "/userimages/{$vImages['image_file']}";
                        }
                        echo ImageSlider::widget(['images' => $images]);
                        ?>
                        <br />
                        <p><a class="btn btn-dark download-collection" id="collection-<?= $vCollection['id'] ?>" href="#">Download collection</a></p>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>