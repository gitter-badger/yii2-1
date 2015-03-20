<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $confirmLink string */
/* @var $username string */
?>

<p>Здравствуйте, <?= Html::encode($username) ?>!</p>

Для подтверждения адреса пройдите по ссылке:</br>

<?= Html::a(Html::encode($confirmLink), $confirmLink) ?></br>

Если Вы не регистрировались у на нашем сайте, то просто удалите это письмо.