<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\modules\user\models\User */

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/confirm-email', 'token' => $user->email_confirm_token]);
?>

<p>Здравствуйте, <?= Html::encode($user->username) ?>!</p>

Для подтверждения адреса пройдите по ссылке:</br>

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?></br>

Если Вы не регистрировались у на нашем сайте, то просто удалите это письмо.