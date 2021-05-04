<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%user_collection}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $username
 * @property string|null $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class UserCollection extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return '{{%user_collection}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['user_id', 'name', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'name', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Collection name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery|UserQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserCollectionImage() {
        return $this->hasMany(\common\models\UserCollectionImage::class, ['usercollection_id' => 'id']);
    }

}
