<?php

namespace api\modules\v1\category\models;

use api\helper\behavior\TimeBehavior;

/**
 * @property mixed|null $id
 */
class Category extends \common\models\Category
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