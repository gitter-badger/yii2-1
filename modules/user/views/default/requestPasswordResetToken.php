<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\modules\user\models\PasswordResetRequestForm */
$this->title = 'Восстановление пароля';
?>
<div class="site-request-password-reset">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <p>Введите ваш email. На него будет отправлена ссылка для востановления пароля. </p>
                <?=Html::beginForm(
                    $action = 'request-password-reset',
                    $method = 'post',
                    $options = [
                        'id'=>'request-password-reset-form',
                        'class' => ''
                    ]
                ) ?>
                <div class="form-group">
                    <?= Html::activeLabel($model,'email', ['class' => 'control-label required']); ?>
                    <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']); ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="ladda-button btn btn-success" data-style="expand-right" data-size="l">
                        <span class="ladda-label">Отправить</span>
                        <span class="ladda-spinner"></span>
                    </button>
                </div>
                <?=Html::endForm() ?>
                <div class="row">
                    <div class="col-sm-6 text-right">
                        <?= Html::a('Регистрация', ['/user/default/registration']) ?>
                    </div>
                    <div class="col-sm-6">
                        <?= Html::a('Войти', ['/user/default/login']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs("
        jQuery('#request-password-reset-form').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var l = Ladda.create( document.querySelector('#request-password-reset-form .ladda-button') );
            l.start();
            $.ajax({
                type: 'post',
                url: config.baseUrl + self.attr('action'),
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
