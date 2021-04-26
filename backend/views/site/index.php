<?php

use coderius\swiperslider\SwiperSlider;
use yii\helpers\Url;
use yii\web\View;
/* @var $this View */

$this->title = 'My Yii Application';
$this->registerJs(<<<JS
            let isDownloading = false;
            $(".download-collection").on("click",function(e){
            e.preventDefault()
            let id = e.currentTarget.id.match(/^collection\-([0-9]+)/)[1]
            if(isDownloading===true){return false}
            isDownloadig = true;
            $.ajax({
            JS .
            'url:"' . Url::to(['site/download']) . '/?id="+id,' .
            'success: function(res){console.log(res); location.href="'. Url::to(['site/download']) . '?id="+id+"&token="+res.download_token+"";},'.
            <<<JS
            })
            //alert(isDownloading)
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
                        foreach ($vCollection['collection'] as $vImages) {
                            $images[] = '<div style="text-align:center; background-color:#000"><img src="' . $vImages['thumb'] . '" /></div>';
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
