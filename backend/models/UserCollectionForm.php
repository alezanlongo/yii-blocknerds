<?php

namespace app\models;

use common\models\User;
use common\models\UserCollection;
use yii\base\Model;

/**
 * Description of UserCollectionForm
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UserCollectionForm extends Model
{

    public $id = null;
    public $collection;

    /**
     * 
     * @var UserCollection
     */
    private $_userCollection = null;

    public function __construct(UserCollection $ucModel = null, $config = []) {
        if (!is_null($ucModel)) {
            $this->_userCollection = $ucModel;
            $this->collection = json_encode($this->_userCollection->collection);
            $this->id = $ucModel->id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['collection', 'trim'],
            ['collection', 'required'],
            [['collection'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'collection' => 'Collection'
        ];
    }

    /**
     * Return model save validation status
     * @param User $userModel
     * @return bool
     */
    public function createCollection(User $userModel) {

        $collection = new UserCollection();
        if (empty($this->collection)) {
            return false;
        }
        $collection->collection = json_decode($this->collection);
        $userModel->link('userCollection', $collection);
        $staus = $userModel->save();
        if ($staus === true) {
            $this->id = $collection->id;
        }
        return $staus;
    }

    /**
     * Update userCollection
     * @return boolean
     */
    public function updateCollection() {
        if (null === $this->_userCollection) {
            return false;
        }
        $this->_userCollection->collection = json_decode($this->collection);
        return $this->_userCollection->save();
    }

}
