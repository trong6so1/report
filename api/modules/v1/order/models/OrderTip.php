<?php

namespace api\modules\v1\order\models;

use api\helper\behavior\TimeBehavior;

class OrderTip extends \common\models\OrderTip
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