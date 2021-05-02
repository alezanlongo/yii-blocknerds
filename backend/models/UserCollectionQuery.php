<?php

namespace backend\models;

use common\models\User;
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
     * Get ullection from active Users
     * @return $this
     */
    static public function getUsersActiveCollections(int $offset = 0, int $limit = 20) {
        return UserCollection::find()->joinWith('user u', true, 'INNER JOIN')->where(['u.status' => User::STATUS_ACTIVE])->offset($offset)->limit($limit);
    }

    /**
     * Get User collections by id
     * @param int $userId
     * @param int $offset
     * @param int $limit
     * @return $this
     */
    static public function getCollectionsByUserId(int $userId, int $offset = 0, int $limit = 20) {
        if ($limit < 0 || $limit > 20) {
            $limit = 20;
        }
        return UserCollection::find()->where(['user_id' => $userId])->offset($offset)->limit($limit);
    }

    /**
     * Get a collection by collection id
     * @param int $userId
     * @param type $collectionId
     * @return mixed
     */
    static public function getUserCollectionById($collectionId) {
        return UserCollection::find()->andWhere(['id' => $collectionId])->one();
    }

    /**
     * {@inheritdoc}
     * @return UserCollection[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserCollection|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
