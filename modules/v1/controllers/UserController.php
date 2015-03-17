<?php

namespace app\modules\v1\controllers;

use yii\rest\Controller;

//use app\models\User;
use app\models\LoginForm;

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
        if ($model->load(\Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            echo \Yii::$app->user->identity->getAuthKey();
        } else {
            $model->validate();
            return $model;
        }
    }
}