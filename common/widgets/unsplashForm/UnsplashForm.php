<?php

namespace common\widgets\unsplashForm;

use yii\base\Widget;

/**
 * Description of UnsplashForm
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UnsplashForm extends Widget
{

    public $formFieldId;

    public function run(): string {
        UnsplashFormAsset::register($this->getView());
        return $this->render('_searchBox', ['formFieldId' => $this->formFieldId]);
    }

}
