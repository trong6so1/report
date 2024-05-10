<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['v1/order' => 'v1/order/order'],
            'extraPatterns' => [
                'POST create' => 'create',
                'GET search' => 'search',
            ],
        ],
    ],
];

