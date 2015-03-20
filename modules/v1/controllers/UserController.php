<?php

namespace app\modules\v1\controllers;

use yii\rest\Controller;

use app\models\LoginForm;
use app\models\RegistrationForm;

class UserController extends Controller
{
    /**
     * Вход на сайт
     *
     * @return LoginForm | string
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->login()) {
            echo \Yii::$app->user->identity->getAuthKey();
        } else {
            return $model;
        }
    }

    /**
     * Регистрация на сайте
     * @return RegistrationForm|bool
     */
    public function actionRegistration()
    {
        $model = new RegistrationForm();
        if ($model->load(\Yii::$app->request->post(), '') && $model->registration()) {
            return true;
        } else {
            return $model;
        }
    }
}