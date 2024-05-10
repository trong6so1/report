<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseService extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%service}}';
    }

    public function rules(): array
    {
        return [
            ['category_id', 'exist', 'targetClass' => BaseCategory::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'name',
            'type',
            'image_base_url',
            'image_path',
            'status',
            'group_id',
            'priority',
            'category_id',
            'onwer_id',
            'point_bonus',
            'duration',
            'buffer_time',
            'show_on_checkin',
            'show_on_booking',
            'show_on_pos',
            'price',
            'supply_share',
            'web_booking_visible',
            'note',
            'create_at',
        ];
    }
}