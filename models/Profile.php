<?php

namespace app\models;

use Yii;

class Profile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'f_profile';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['avatar'], 'string', 'max' => 255],
            [['city'], 'string', 'max' => 70],
            [['address', 'phone'], 'string', 'max' => 150]
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'avatar' => 'Avatar',
            'city' => 'City',
            'address' => 'Address',
            'phone' => 'Phone',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
