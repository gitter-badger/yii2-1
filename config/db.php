<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2test',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix'=>'y_',
    'schemaCacheDuration' => YII_DEBUG ? 300 : 1*24*3600, // 1 days
];