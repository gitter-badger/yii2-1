<?php
use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" ng-app="app">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="web development">
    <meta name="author" content="Alexandr Grischuk">
    <meta name="keywords" content="web, php, разработка сайтов, разработка стартапов">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body id="page-top" data-spy="scroll" data-target=".navbar-custom">

<?php $this->beginBody() ?>

    <?= $content ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
