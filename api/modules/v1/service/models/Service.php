<?php

namespace api\modules\v1\service\models;

use api\helper\behavior\TimeBehavior;

class Service extends \common\models\Service
{
    public function behaviors(): array
    {
        return [
          'timestamp' => [
              'class' => TimeBehavior::class,
              'createdAtAttribute' => 'create_at',
              'updatedAtAttribute' => false,
          ]
        ];
    }
}