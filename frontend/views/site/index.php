<?php

use coderius\swiperslider\SwiperSlider;
use yii\helpers\Url;
use yii\web\View;

/* @var $this View */

$this->title = 'My Yii Application';
$this->registerJs(<<<JS
            var isDownloading = false;
            $(".download-collection").on("click",function(e){
            e.preventDefault()
            let id = e.currentTarget.id.match(/^collection\-([0-9]+)/)[1]
            if(isDownloading===true){return false}
            isDownloadig = true;
            $.ajax({
            JS .
        'url:"' . Url::to(['site/download']) . '/?id="+id,' .
        'success: function(res){isDownloading=false;location.href="' . Url::to(['site/download']) . '?id="+id+"&token="+res.download_token+"";},' .
        <<<JS
             error: function(err){isDownloading = false; alert('error: '+err.responseText)}
            })
            //alert(isDownloading)
        })
        
        JS, View::POS_READY);
yii\helpers\VarDumper::dump($this,  $dept = 10,  $highlight = true);
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
                            $images[] = '<div style="text-align:center; background-color:#000"><img src="/userimages/' . $vImages['image_file'] . '" /></div>';
                        }
                        echo SwiperSlider::widget([
                            'slides' => $images]);
                        ?>
                        <br />
                        <p><a class="btn btn-default download-collection" id="collection-<?= $vCollection['id'] ?>" href="#">Download collection &raquo;</a></p>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</div>