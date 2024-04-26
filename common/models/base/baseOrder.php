<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class baseOrder extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order}}';
    }
}