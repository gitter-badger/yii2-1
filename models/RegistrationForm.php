<?php

namespace app\models;

use yii\base\Model;
use app\modules\user\helpers\GenerateUsername;

/**
 * Форма регистрации
 */
class RegistrationForm extends Model
{
    /** @var string */
    public $first_name;
    /** @var string */
    public $last_name;
    /** @var string */
    public $email;
    /** @var string */
    public $phone;
    /** @var string */
    public $password;
    /** @var string */
    public $verifyPassword;

    /** @var Object */
    private $user;
    /** @var Object */
    private $profile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['first_name', 'filter', 'filter' => 'trim'],
            ['first_name', 'required'],

            ['last_name', 'filter', 'filter' => 'trim'],
            ['last_name', 'required'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => 'app\models\User' ],

            ['phone', 'filter', 'filter' => 'trim'],
            ['phone', 'required'],

            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'required'],

            ['verifyPassword', 'filter', 'filter' => 'trim'],
            ['verifyPassword', 'required'],
            ['verifyPassword', 'compare', 'compareAttribute'=>'password'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->user = \Yii::createObject([
            'class'    => User::className(),
            'scenario' => 'register'
        ]);
        $this->profile = \Yii::createObject([
            'class'    => Profile::className()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name'      => 'Имя',
            'last_name'       => 'Фамилия',
            'email'           => 'Email',
            'phone'           => 'Номер телефона',
            'password'        => 'Пароль',
            'verifyPassword'  => 'Повторите пароль'
        ];
    }

    /**
     * Регистрация на сайте
     * @return bool
     */
    public function registration()
    {
        if ($this->validate()) {
            $this->user->setAttributes([
                'email'    => $this->email,
                'password' => $this->password
            ]);
            $this->user->uniqueUsername( GenerateUsername::run($this->first_name . '_' . $this->last_name));
            $this->profile->setAttributes([
                'first_name'    => $this->first_name,
                'last_name'     => $this->last_name,
                'phone'         => $this->phone,
            ]);
            $transaction = \Yii::$app->db->beginTransaction();
            if ($this->user->save()) {
                $this->user->link('profile', $this->profile);
                $transaction->commit();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}