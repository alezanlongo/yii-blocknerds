<?php

namespace common\widgets\unsplashForm;

use yii\web\AssetBundle;

/**
 * Description of UnsplashFormAsset
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UnsplashFormAsset extends AssetBundle
{

//    public $js = [
//        'js/unsplash-form.js'
//    ];
    public $css = [
        'css/unsplash-form.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init() {
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }

    public $publishOptions = [
        'forceCopy' => true,
    ];

}
