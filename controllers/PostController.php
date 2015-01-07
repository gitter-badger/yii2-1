<?php

namespace app\controllers;

use yii\web\Controller;

class PostController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
