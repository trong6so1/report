<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseOrderTip extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_tip}}';
    }

    public function rules(): array
    {
        return [
            ['order_id', 'exist', 'targetClass' => BaseOrder::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    public function fields(): array
    {
        return [
            'id',
            'order_id',
            'status',
            'is_updated',
            'total_tip',
            'tip_type',
            'payment_method',
            'giftcard_code',
            'data',
            'data_after_charge',
            'created_at',
            'updated_at',
        ];
    }
}