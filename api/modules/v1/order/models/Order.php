<?php

namespace api\modules\v1\order\models;

use api\helper\behavior\TimeBehavior;

class Order extends \common\models\Order
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