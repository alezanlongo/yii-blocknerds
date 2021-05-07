<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class UserCollectionImageFixture extends ActiveFixture
{

    public $modelClass = 'common\models\UserCollectionImage';
    public $depends = ['common\fixtures\UserCollectionFixture'];

}
