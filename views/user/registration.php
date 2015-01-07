<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php $form = ActiveForm::begin([
                    'id' => 'register-form',
                    'enableClientValidation' => false,
                    'enableClientScript' => false,
                    'options' => [
                        'ng-submit' => 'submit()'
                    ]
                ]); ?>

                <?= $form->field($model, 'first_name') ?>

                <?= $form->field($model, 'last_name') ?>

                <?= $form->field($model, 'phone') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'verifyPassword')->passwordInput() ?>

                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success btn-block']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a('Already registered? Sign in!', ['/user/security/login']) ?>
        </p>

        <button ladda="loginLoading" ng-click="login()" class="btn btn-success" data-style="expand-right">
            Login
        </button>

        {{name}}

    </div>
</div>