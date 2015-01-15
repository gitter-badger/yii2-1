<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone;
    public $verifyPassword;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['phone', 'first_name', 'last_name', 'email', 'password', 'verifyPassword'], 'filter', 'filter' => 'trim'],
            [['phone', 'first_name', 'last_name', 'email', 'password', 'verifyPassword'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            ['verifyPassword', 'compare', 'compareAttribute'=>'password'],

        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email'    => 'Email',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'verifyPassword' => 'Повторите пароль'
        ];
    }

    /** @inheritdoc */
    public function formName()
    {
        return 'register-form';
    }

    /**
     * Registers a new user account.
     * @return bool
     */
    public function register()
    {
        if ($this->validate()) {
            $user = $this->module->manager->createUser([
                'scenario' => 'register',
                'email'    => $this->email,
                'username' => $this->username,
                'password' => $this->password
            ]);

            return $user->register();
        }

        return false;
    }
}