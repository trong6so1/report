<?php

namespace api\modules\v1\report\controllers;

class Controller extends \yii\rest\Controller
{
    public function verbs(): array
    {
        return [
            'index' => ['GET'],
            'create' => ['POST'],
            'search' => ['GET']
        ];
    }
}