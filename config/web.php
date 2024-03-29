<?php

$config = [
    'name' => 'Натуральные продукты',
    'id' => 'app',
    'defaultRoute' => 'main/default/index',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'bootstrap' => ['log'],
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'assetManager' => [
            'bundles' => require(__DIR__ . '/bundles.php'),
        ],
        'urlManager' => require(__DIR__ . '/routes.php'),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'I21bYSGwnkD1C2kniqe5wjpgUsynA9xf',
        ],
        'cache' => require(__DIR__ . '/memcache.php'),
        'user' => [
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['user/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/default/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            /*'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'grischuk.alexandr@gmail.com',
                'password' => 'alexander2703',
                'port' => '587',
                'encryption' => 'tls',
            ],*/
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => require(__DIR__ . '/params.php'),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';

    $config['components']['assetManager']['forceCopy'] = true;
}

return $config;
