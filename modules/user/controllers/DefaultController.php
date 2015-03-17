<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;

use app\models\User;
use app\models\LoginForm;

use app\modules\user\models\Profile;

use app\modules\user\helpers\GenerateUsername;
use app\modules\user\models\ConfirmEmailForm;
use app\modules\user\models\PasswordResetRequestForm;
use app\modules\user\models\ResetPasswordForm;

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
                    $m = Yii::$app->mailer->compose('confirmEmail', ['user' => $user])
                        ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
                        ->setTo($user->email)
                        ->setSubject('Email confirmation for ' . Yii::$app->name)
                        ->send();
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

    /**
     * Открывает форму для логина
     *
     * @return string
     */
    public function actionLogin(){

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => new LoginForm(),
        ]);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionConfirmEmail($token)
    {
        try {
            $model = new ConfirmEmailForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Ваш Email успешно подтверждён.');
        } else {
            Yii::$app->getSession()->setFlash('error', 'Ошибка подтверждения Email.');
        }

        return $this->goHome();
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        $request = Yii::$app->request;
        if ($request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $errors = ActiveForm::validate($model);
            if(count($errors) != 0){
                echo json_encode($errors);
            } else {
                if ($model->sendEmail()) {
                    Yii::$app->getSession()->setFlash('success', 'Спасибо! На ваш Email было отправлено письмо со ссылкой на восстановление пароля.');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Извините. У нас возникли проблемы с отправкой.');
                }
                echo json_encode(['url' => Yii::$app->homeUrl]);
            }
            Yii::$app->end();
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Спасибо! Пароль успешно изменён.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
