<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionAbout()
    {
        return $this->render('about');
    }
}
