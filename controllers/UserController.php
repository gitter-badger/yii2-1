<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Profile;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRegistration(){

        $user = new User;
        $user->scenario = 'register';
        $profile = new Profile;

        $request = Yii::$app->request;
        if ($request->isAjax && $user->load($request->post()) && $profile->load($request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $errors = ActiveForm::validate($user, $profile);
            if(count($errors) != 0){
                echo json_encode($errors);
            } else {
                $user->username = \app\helpers\GenerateUsername::run($profile->first_name . '_' . $profile->last_name);
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!$user->save()) {
                        throw new \Exception( Html::errorSummary($user) );
                    }
                    $profile->user_id = $user->id;
                    if (!$profile->save())
                        throw new \Exception( Html::errorSummary($profile) );
                    $transaction->commit();
                    Yii::$app->session->setFlash('success','Регистрация прошла успешно.');
                    echo json_encode([
                        'url' => Yii::$app->homeUrl
                    ]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->errorHandler->handleException($e);
                }
            }
            Yii::$app->end();
        }

        return $this->render('registration', [
            'user' => $user,
            'profile' => $profile
        ]);
    }

    public function actionLogin(){

        return $this->render('login');
    }


}
