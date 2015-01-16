<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\user\models\User;
use app\modules\user\models\Profile;
use app\modules\user\models\LoginForm;
use app\modules\user\helpers\GenerateUsername;

class DefaultController extends Controller
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
                $user->username = GenerateUsername::run($profile->first_name . '_' . $profile->last_name);
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
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        $request = Yii::$app->request;
        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $errors = ActiveForm::validate($model);
            if(count($errors) != 0){
                echo json_encode($errors);
            } else {
                $model->login();
            }
            Yii::$app->end();
        }



        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
