<?php

namespace app\models;

use Yii;

class Profile extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%profile}}';
    }

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone'], 'required'],
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
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'phone' => 'Номер телефона',
            'avatar' => 'Avatar',
            'city' => 'City',
            'address' => 'Address',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
