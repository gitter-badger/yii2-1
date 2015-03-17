<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

$success = Yii::$app->session->hasFlash('success');
$error = Yii::$app->session->hasFlash('error');
if($success || $error){
    if($success){
        $message = Yii::$app->session->getFlash('success');
        $class = 'alert-success';
    } else{
        $message = Yii::$app->session->getFlash('error');
        $class = 'alert-danger';
    }
    $this->registerJs("
            app.alert('{$message}', '{$class}');
    ", yii\web\View::POS_END, 'alert');
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<div class="modal fade"></div>
<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'My Company',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/main/default/index']],
                    ['label' => 'About', 'url' => ['/main/default/about']],
                    ['label' => 'Contact', 'url' => ['/main/contact/index']],
                    Yii::$app->user->isGuest ? ['label' => 'Регистрация', 'url' => ['/user/default/registration']] : [],
                        Yii::$app->user->isGuest ?
                        ['label' => 'Login', 'url' => ['/user/default/login']]:
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/default/logout'],
                            'linkOptions' => ['data-method' => 'post']],
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
