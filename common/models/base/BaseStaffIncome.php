<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseStaffIncome extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%staff_income}}';
    }
}