<?php

namespace api\modules\v1\product\controllers;

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