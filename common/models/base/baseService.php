<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class baseService extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%service}}';
    }
}