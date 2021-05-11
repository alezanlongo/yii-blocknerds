<?php

namespace backend\models;

use common\components\ImageStorageComponent;
use common\models\User;
use common\models\UserCollection;
use common\models\UserCollectionImage;
use InvalidArgumentException;
use Yii;
use yii\base\Model;
use yii\httpclient\Exception;
use function mb_substr;

/**
 * Description of UserCollectionForm
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class UserCollectionForm extends Model
{

    public $id = null;
    public $collection;
    public $name;

    /**
     * 
     * @var UserCollection
     */
    private $_userCollection = null;

    public function __construct(UserCollection $ucModel = null, $config = []) {
        if (!is_null($ucModel)) {
            $this->_userCollection = $ucModel;
            $this->name = $ucModel->name;
            $ucImgs = $ucModel->getUserCollectionImage()->orderBy('position', 'asc')->all();
            foreach ($ucImgs as $v) {
                $res[] = ['id' => $v['external_image_id'], 'alt_description' => $v['title'], 'thumb' => '/userimages/' . $v['image_file']];
            }
            $this->collection = json_encode($res);
            $this->id = $ucModel->id;
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['name', 'trim'],
            ['name', 'required'],
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
            'collection' => 'Collection',
            'name' => 'Collection\'s name'
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

        $collectionForm = json_decode($this->collection, true);
        if (!is_array($collectionForm)) {
            throw new InvalidArgumentException('invalid collection data');
        }

        $collection->name = mb_substr($this->name, 0, 254);
        $userModel->link('userCollection', $collection);
        $staus = $userModel->save();
        if ($staus === true) {
            $this->id = $collection->id;
        }
        try {
            foreach ($collectionForm as $k => $v) {
                $imgArr = Yii::$app->unsplashApi->reduceSearchResult(['results' => [Yii::$app->unsplashApi->getPhotoById($v['id'])]], ['alt_description'])['results'][0];
                $filename = Yii::$app->imageStorage->storeImage($userModel->getId(), $this->id, $v['id'], $imgArr['img'], ImageStorageComponent::IMAGE_TYPE_IMG);
                $newUci = new UserCollectionImage();
                $newUci->external_image_id = $v['id'];
                $newUci->title = $imgArr['alt_description'];
                $newUci->position = $k;
                $newUci->image_file = $filename;
                $collection->link('userCollectionImage', $newUci);
            }
            return $collection->save();
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Update userCollection
     * @return boolean
     */
    public function updateCollection() {
        if (null === $this->_userCollection) {
            return false;
        }

        $collectoinForm = json_decode($this->collection, true);
        if (!is_array($collectionForm)) {
            throw new InvalidArgumentException('invalid collection data');
        }
        $ucimgs = $this->_userCollection->getUserCollectionImage()->all();
        $toUpd = [];
        $toAdd = [];
        foreach ($collectoinForm as $k => $v) {
            $flag = false;
            foreach ($ucimgs as $kDb => $vDb) {
                try {
                    if (!isset($v['id']) || !isset($vDb['external_image_id'])) {
//                        var_dump($v,$vDb);die;
                    }

                    if ($v['id'] == $vDb['external_image_id']) {
                        $flag = true;
                        $toUpd[$kDb] = $k;
                    }
                } catch (Exception $ex) {
                    
                }
            }
            if ($flag === false) {
                $toAdd[$k] = true;
            }
        }
        $toDel = array_diff(array_keys($ucimgs), array_keys($toUpd));
        if (!empty($toUpd)) {
            foreach ($toUpd as $k => $v) {
                if ($ucimgs[$k]['position'] !== $v) {
                    $ucimgs[$k]['position'] = $v;
                    $ucimgs[$k]->save();
                }
            }
        }
        if (!empty($toDel)) {
            foreach ($toDel as $v) {
                Yii::$app->imageStorage->deleteImage($ucimgs[$v]['image_file']);
                $ucimgs[$v]->delete();
            }
        }
        if (!empty($toAdd)) {
            foreach ($toAdd as $k => $v) {

                $v = $collectoinForm[$k]['id'];
                $imgArr = Yii::$app->unsplashApi->reduceSearchResult(['results' => [Yii::$app->unsplashApi->getPhotoById($v)]], ['alt_description'])['results'][0];
                $filename = Yii::$app->imageStorage->storeImage($this->_userCollection->getUser()->one()->getId(), $this->id, $v, $imgArr['img'], ImageStorageComponent::IMAGE_TYPE_IMG);
                $newUci = new UserCollectionImage();
                $newUci->external_image_id = $v;
                $newUci->title = $imgArr['alt_description'];
                $newUci->position = $k;
                $newUci->image_file = $filename;
                $this->_userCollection->link('userCollectionImage', $newUci);
            }
        }
        //Update for avoid download zip cache
        if (!empty($toAdd) || !empty($toDel) || !empty($toUpd)) {
            $this->_userCollection->updated_at = time();
        }
        $this->_userCollection->name = $this->name;
        return $this->_userCollection->save();
    }

}
