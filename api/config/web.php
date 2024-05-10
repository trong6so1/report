<?php

use yii\web\Response;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
$config = [
    'defaultRoute' => 'site/index',
    'modules' => [
        'v1' => [
            'class' => api\modules\v1\Module::class,
        ],
    ],
    'bootstrap' => ['log', 'queue'],
    'components' => [
        'user' => [
            'identityClass' => 'api\base\Identity'
        ],
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => true,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Asia/Ho_Chi_Minh',
        ],
        'redis' => [
            'class' => \yii\redis\Connection::class,
            'hostname' => 'localhost',
            'port' => 8081,
            'retries' => 1,
        ],
        'queue' => [
            'class' => \yii\queue\redis\Queue::class,
            'redis' => 'redis', // Redis connection component or its config
            'channel' => 'queue', // Queue channel key
        ],

        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                    'logFile' => '@runtime/logs/queue.log',
                ],
            ],
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => false,
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.gmail.com',
//                'username' => 'trong6so1@gmail.com',
//                'password' => 'thanhhien',
//                'port' => '587',
//                'encryption' => 'tls',
//            ],
//        ],
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
        ],
    ],

    'params' => $params
];

return $config;
