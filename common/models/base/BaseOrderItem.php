<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseOrderItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_items}}';
    }
}