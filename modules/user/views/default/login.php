<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
?>
<div class="site-login">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?=Html::beginForm(
                    $action = 'user/default/login',
                    $method = 'post',
                    $options = [
                        'id'=>'login-form',
                        'class' => 'form-horizontal'
                    ]
                ) ?>
                <div class="form-group">
                    <?= Html::activeLabel($model,'username', [ 'class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($model, 'username', ['class' => 'form-control']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::activeLabel($model,'password', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($model, 'password', ['class' => 'form-control']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <?= Html::activeCheckbox($model, 'rememberMe', ['class' => '']); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="ladda-button btn btn-success" data-style="expand-right" data-size="l">
                            <span class="ladda-label">Войти</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>
                <?=Html::endForm() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 text-right">
                <?= Html::a('Регистрация', ['/user/default/registration']) ?>
            </div>
            <div class="col-sm-6">
                <?= Html::a('Забыли пароль?', ['/user/default/registration']) ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs("
        jQuery('#login-form').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var l = Ladda.create( document.querySelector('#login-form .ladda-button') );
            l.start();
            $.ajax({
                type: 'post',
                url: app.baseUrl + self.attr('action'),
                dataType: 'json',
                data: self.serialize(),
                success: function(data) {
                    console.log(data);
                    if(data.url){
                         window.location = data.url;
                    } else {
                        var errors;
                        if( errors = self.find('.text-danger') )
                            errors.remove();
                        $.each(data, function(key, val){
                            var input = self.find( '#' + key);
                            input.closest('div').append('<div class=\'text-danger\'>' + val + '</div>');
                        });
                    }
                }
            }).always(function() { l.stop(); });
        });

    ", \yii\web\View::POS_END, 'my-options');
?>
