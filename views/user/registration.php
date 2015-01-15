<?php
    use yii\helpers\Html;
    use yii\web\View;
    $this->title = 'Регистрация';

?>
<style>

    .required:after{
        content: ' *';
        color: #a94442
    }
</style>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">

                <?=Html::beginForm(
                    $action = 'user/registration',
                    $method = 'post',
                    $options = [
                        'id'=>'register-form',
                        'class' => 'form-horizontal'
                    ]
                ) ?>

                <div class="form-group">
                    <?= Html::activeLabel($profile,'first_name', [ 'class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($profile, 'first_name', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($profile,'last_name', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($profile, 'last_name', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($user,'email', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($user, 'email', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($profile,'phone', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activeTextInput($profile, 'phone', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($user,'password', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activePasswordInput($user, 'password', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= Html::activeLabel($user,'verifyPassword', ['class' => 'col-sm-4 control-label required']); ?>
                    <div class="col-sm-8">
                        <?= Html::activePasswordInput($user, 'verifyPassword', ['class' => 'form-control']); ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="ladda-button btn btn-success" data-style="expand-right" data-size="l">
                            <span class="ladda-label">Send</span>
                            <span class="ladda-spinner"></span>
                        </button>
                    </div>
                </div>

                <?=Html::endForm() ?>


            </div>
        </div>
        <p class="text-center">
            <?= Html::a('Already registered? Sign in!', ['/user/security/login']) ?>
        </p>

        <button ladda="loginLoading" ng-click="login()" class="btn btn-success" data-style="expand-right">
            Login
        </button>


    </div>
</div>

<?php
    $this->registerJs("
        jQuery('#register-form').submit(function(e){
            e.preventDefault();
            var self = $(this);
            var l = Ladda.create( document.querySelector('#register-form .ladda-button') );
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

    ", View::POS_END, 'my-options');
?>