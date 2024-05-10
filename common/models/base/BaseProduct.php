<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseProduct extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%product}}';
    }
    public function fields(): array
    {
        return [
            'id',
            'name',
            'image_url',
            'type',
            'status',
            'price',
            'created_at',
            'updated_at'
        ];
    }

}