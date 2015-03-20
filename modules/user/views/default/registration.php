<?php
    use yii\helpers\Html;
    use yii\web\View;
    $this->title = 'Регистрация';
?>
<div class="row registration" ng-controller="RegistrationCtrl">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <form role="form" id="registration-form" class="form-horizontal" method="post">
                    <div class="form-group">
                        <?= Html::activeLabel($model,'first_name', [ 'class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activeTextInput($model, 'first_name', ['class' => 'form-control', 'ng-model' => 'model.first_name']); ?>
                            <error field="first_name"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'last_name', ['class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activeTextInput($model, 'last_name', ['class' => 'form-control', 'ng-model' => 'model.last_name']); ?>
                            <error field="last_name"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'email', ['class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activeTextInput($model, 'email', ['class' => 'form-control', 'ng-model' => 'model.email']); ?>
                            <error field="email"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'phone', ['class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activeTextInput($model, 'phone', ['class' => 'form-control', 'ng-model' => 'model.phone']); ?>
                            <error field="phone"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'password', ['class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'ng-model' => 'model.password']); ?>
                            <error field="password"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <?= Html::activeLabel($model,'verifyPassword', ['class' => 'col-sm-4 control-label required-field']); ?>
                        <div class="col-sm-8">
                            <?= Html::activePasswordInput($model, 'verifyPassword', ['class' => 'form-control', 'ng-model' => 'model.verifyPassword']); ?>
                            <error field="verifyPassword"></error>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-success" ladda="loading" ng-click="registration()">
                                Регистрация
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center">
            <?= Html::a('Войти', ['/user/default/login']) ?>
        </p>
    </div>
</div>