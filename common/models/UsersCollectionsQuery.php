<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[UserCollection]].
 *
 * @see UserCollection
 */
class UsersCollectionsQuery extends \yii\db\ActiveQuery
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
     * @return $this
     */
    public function getCollectionsByUserId(int $userId, int $offset = 0, int $limit = 20) {
        if ($limit < 0 || $limit > 20) {
            $limit = 20;
        }
        return $this->where(['user_id' => $userId])->offset($offset)->limit($limit);
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
