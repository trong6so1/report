<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class baseOrderPaymentMethod extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_payment_method}}';
    }
}