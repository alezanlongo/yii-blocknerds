<?php

namespace common\widgets\imageSliderLightbox;

use yii\web\AssetBundle;

/**
 * Description of ImageSliderAsset
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageSliderLightboxAsset extends AssetBundle
{

    public $js = [
        'js/image-slider-lightbox.js'
    ];
    public $css = [
        'css/image-slider-lightbox.css'
    ];
    public $depends = [
    ];

    public function init() {
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

    public $publishOptions = [
        'forceCopy' => true,
    ];


}
