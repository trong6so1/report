<?php

namespace api\modules\v1\order\models;

use api\helper\behavior\TimeBehavior;

class OrderItem extends \common\models\OrderItem
{
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimeBehavior::class,
            ]
        ];
    }
}