<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseOrderCode extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_code}}';
    }
}