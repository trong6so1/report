<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseEmployee extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%employee}}';
    }
}