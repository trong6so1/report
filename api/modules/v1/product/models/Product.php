<?php

namespace api\modules\v1\product\models;

use api\helper\behavior\TimeBehavior;

class Product extends \common\models\Product
{
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimeBehavior::class
            ]
        ];
    }
}