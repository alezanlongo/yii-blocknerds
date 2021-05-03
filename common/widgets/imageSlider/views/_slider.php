<?php

use yii\web\View;

/**
 * Description of slider
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
/* @var $this View */

$id = 'image-slider-' . uniqid();
$this->registerJs("$(\"#$id\").imageSlider();", View::POS_READY);
?>
<div class="image-slider" id="<?= $id ?>">
    <div class="nav">
        <div class="l">&lt;</div>
        <div class="r">&gt;</div>
    </div>
    <ul>
        <?php
        foreach ($images as $v) {
            echo '<li><p>view</p><img src="' . $v . '" /></li>';
        }
        ?>    
    </ul>
</div>
