<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\RegistrationForm;

class UserController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration(){

        $model = new RegistrationForm;

        return $this->render('registration', [
            'model' => $model
        ]);
    }

}
