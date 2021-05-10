<?php

namespace common\widgets\imageSliderLightbox;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Description of ImageSlider
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class ImageSliderLightbox extends Widget
{

    public $images = [];

    public function init() {
        
    }

    public function run(): string {
        ImageSliderLightboxAsset::register($this->getView());
        return $this->render('_slider', ['images' => $this->images]);
    }

}
