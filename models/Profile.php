<?php

namespace app\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "y_profile".
 *
 * @property integer $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $avatar
 * @property string $city
 * @property string $address
 * @property string $phone
 *
 * @property User $user
 */
class Profile extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],

            ['first_name', 'required'],
            ['first_name', 'string', 'max' => 100],

            ['last_name', 'required'],
            ['last_name', 'string', 'max' => 100],

            ['phone', 'required'],
            ['phone', 'string', 'max' => 150],

            ['avatar', 'string', 'max' => 255],

            ['city', 'string', 'max' => 70],

            ['address', 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'phone' => 'Номер телефона',
            'avatar' => 'Avatar',
            'city' => 'Город',
            'address' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
