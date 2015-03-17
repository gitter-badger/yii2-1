<?php

return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'main/default/index',
        '<_a:(login|logout|registration|confirm-email|request-password-reset|reset-password)>' => 'user/default/<_a>',

        '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
        '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
        '<_m:[\w\-]+>' => '<_m>/default/index',
        '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
    ],
];