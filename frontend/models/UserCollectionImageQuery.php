<?php

namespace frontend\models;

use common\models\UserCollectionImage;
use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;

/**
 * Description of UserCollectionImageQuery
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UserCollectionImageQuery extends UserCollectionImage
{

    /**
     * 
     * @param int $userId
     * @param int $imageId
     * @return ActiveQuery
     */
    static public function getUserImageById(int $userId, int $imageId): ActiveQuery {
        return parent::find()->alias('img')->innerJoinWith(['usercollection'], true)->where(['img.id' => $imageId, 'user_collection.user_id' => $userId]);
    }

}
