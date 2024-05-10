<?php

namespace api\modules\v1\service\controllers;

class Controller extends \yii\rest\Controller
{
    public function verbs(): array
    {
        return [
            'create' => ['POST'],
            'search' => ['GET']
        ];
    }
}