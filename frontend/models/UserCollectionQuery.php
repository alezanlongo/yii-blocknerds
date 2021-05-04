<?php

namespace frontend\models;

use common\models\UserCollection;

/**
 * This is the ActiveQuery class for [[UserCollection]].
 *
 * @see UserCollection
 */
class UserCollectionQuery extends UserCollection
{
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * Get User collections by id
     * @param int $userId
     * @param int $offset
     * @param int $limit
     * @return \yii\db\ActiveQuery;
     */
    static public function getCollectionsByUserId(int $userId, int $offset = 0, int $limit = 20) {
        if ($limit < 0 || $limit > 20) {
            $limit = 20;
        }
        return parent::find()->where(['user_id' => $userId])->offset($offset)->limit($limit);
    }

    /**
     * Get a collection by collection id and user id
     * @param int $userId
     * @param type $collectionId
     * @return mixed
     */
    static public function getUserCollectionById(int $userId, $collectionId) {
        return parent::find()->where(['user_id' => $userId])->andWhere(['id' => $collectionId])->one();
    }

    /**
     * {@inheritdoc}
     * @return UserCollection[]|array
     */
    static public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserCollection|array|null
     */
    static public function one($db = null) {
        return parent::one($db);
    }

}
