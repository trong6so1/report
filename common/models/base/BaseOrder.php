<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseOrder extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order}}';
    }
}