<?php

use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\web\View;

/**
 * Description of slieder
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
/* @var $this View */
//var_dump($images);
?>
<div class="image-slider">
    <div class="nav l">&lt;</div>
    <div class="nav r">&gt;</div>
    <ul class="image-slider">
        <?php
        foreach ($images as $v) {
            echo '<li><img src="' . $v . '" /></li>';
        }
        ?>    
    </ul>
</div>
