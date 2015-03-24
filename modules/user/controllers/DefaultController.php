<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\BadRequestHttpException;

use app\models\RegistrationForm;
use app\models\LoginForm;
use app\models\User;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Открывает форму для регистрации
     *
     * @return string
     */
    public function actionRegistration(){

        $model = new RegistrationForm();

        return $this->render('registration', [
            'model' => $model,
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

    /**
     * Подтверждения email адреса из письма отправленого при регистрации
     * @param $token
     * @return \yii\web\Response
     */
    public function actionConfirmEmail($token)
    {
        $confirm = User::confirmEmail($token);
        Yii::$app->getSession()->setFlash( $confirm['status'], $confirm['message']);

        return $this->goHome();
    }

    public function actionLogout(){
        Yii::$app->user->logout();
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
