<?php

namespace api\modules\v1\order\models;

use api\helper\behavior\TimeBehavior;

class OrderPaymentMethod extends \common\models\OrderPaymentMethod
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