<?php

namespace common\models;

use common\models\UserCollection;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_collection_image".
 *
 * @property int $id
 * @property int $usercollection_id
 * @property string|null $external_image_id
 * @property string|null $title
 * @property string|null $thumb_file
 * @property string|null $image_file
 * @property int|null $position
 * @property int $created_at
 * @property int $updated_at
 *
 * @property UserCollection $usercollection
 */
class UserCollectionImage extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user_collection_image';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['usercollection_id', 'created_at', 'updated_at'], 'required'],
            [['usercollection_id', 'position', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['usercollection_id', 'position', 'created_at', 'updated_at'], 'integer'],
            [['external_image_id'], 'string', 'max' => 50],
            [['title', 'thumb_file', 'image_file'], 'string', 'max' => 255],
            [['usercollection_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserCollection::className(), 'targetAttribute' => ['usercollection_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'usercollection_id' => 'Usercollection ID',
            'external_image_id' => 'External Image ID',
            'title' => 'Title',
            'thumb_file' => 'Thumb File',
            'image_file' => 'Image File',
            'position' => 'Position',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Usercollection]].
     *
     * @return ActiveQuery
     */
    public function getUsercollection() {
        return $this->hasOne(UserCollection::className(), ['id' => 'usercollection_id']);
    }

}
