<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'f_user';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'role', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at', 'lastvisit_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['aktiv_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'aktiv_key' => 'Aktiv Key',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'lastvisit_at' => 'Lastvisit At',
            'status' => 'Status',
        ];
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
}
