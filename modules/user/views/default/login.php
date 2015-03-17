<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

$this->title = 'Вход на сайт';
?>
<div class="site-login" ng-controller="LoginCtrl">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <form role="form" id="login-form" class="form-horizontal" ng-submit="login()">
                    <div class="form-group">
                        <?= Html::activeLabel($model,'username', [ 'class' => 'col-sm-4 control-label required']); ?>
                        <div class="col-sm-8">
                            <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'ng-model' => 'model.username']); ?>
                            <error field="username"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'password', ['class' => 'col-sm-4 control-label required']); ?>
                        <div class="col-sm-8">
                            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'ng-model' => 'model.password']); ?>
                            <error field="password"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <?= Html::activeCheckbox($model, 'rememberMe', ['class' => '']); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-success" ladda="loginLoading">
                                Войти
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-sm-6 text-right">
                        <?= Html::a('Регистрация', ['/user/default/registration']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= Html::a('Забыли пароль?', ['/user/default/request-password-reset']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
