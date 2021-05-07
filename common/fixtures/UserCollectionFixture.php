<?php

namespace common\fixtures;

use yii\test\ActiveFixture;

class UserCollectionFixture extends ActiveFixture
{

    public $modelClass = 'common\models\UserCollection';
    public $depends = ['common\fixtures\UserFixture'];

}
