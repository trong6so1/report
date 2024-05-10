<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseCustomerCheckin extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%customer_checkin}}';
    }
}