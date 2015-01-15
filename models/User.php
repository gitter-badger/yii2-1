<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord
{
    public $verifyPassword;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['email', 'password', 'verifyPassword'], 'required', 'on'=>'register'],
            ['verifyPassword', 'compare', 'compareAttribute'=>'password'],
            ['email', 'email'],

            [['created_at', 'updated_at', 'lastvisit_at', 'status'], 'integer'],
            [['username'], 'string', 'max' => 25],
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['aktiv_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 20],

            [['email'], 'unique'],

            [['username'], 'unique', 'on'=>'update'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Пароль',
            'verifyPassword' => 'Повторите пароль',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert == true){
                $this->uniqueUsername();
            }
            return true;
        } else {
            return false;
        }
    }

    public function uniqueUsername( $username = null ){
        if($username == null) $username = $this->username;
        $user = self::find()->where(['username' => $username])->one();
        if($user){
            $names = explode('_', $username);
            $n = array_pop( $names );
            if(is_numeric($n)){
                $names[] = (int)$n +1;
                $this->uniqueUsername( implode("_", $names) );
            } else {
                $this->uniqueUsername( $username . "_1" );
            }
        } else {
            $this->username = $username;
        }
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ];
    }
}
