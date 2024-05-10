<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseCategory extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%category}}';
    }
    public function fields(): array
    {
        return [
            'id',
            'name',
            'status',
            'type',
            'image_base_url',
            'image_path',
            'priority',
            'parent_id',
            'owner_id',
            'created_by',
            'group_id',
            'description',
            'created_at',
            'updated_at',
        ];
    }
}