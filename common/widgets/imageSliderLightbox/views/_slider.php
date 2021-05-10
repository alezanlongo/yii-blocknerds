<?php

use yii\web\View;

/**
 * Description of slider
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
/* @var $this View */

$id = 'image-slider-' . uniqid();
//$this->registerJs("$(\"#$id\").imageSlider();", View::POS_READY);
?>

<div id="myModal" class="islb-modal">
    <span class="islb-modal-close" onclick="closeModal()">&times;</span>
    <div class="autoplay play" id="autoplay" onclick="autoplay()"></div>
    <div class="modal-content">
        <?php
        $total = count($images);
        foreach ($images as $k => $v):
            ?>    

            <div class="mySlides">
                <div class="numbertext"><?= ($k + 1) . " / $total" ?></div>
                <img src="<?= $v ?>">
            </div>
        <?php endforeach; ?>
        <!-- Next/previous controls -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>

        <!-- Caption text -->
        <div class="caption-container">
            <p id="caption"></p>
        </div>
    </div>
</div>
