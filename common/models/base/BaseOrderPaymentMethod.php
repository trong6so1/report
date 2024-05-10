<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseOrderPaymentMethod extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_payment_method}}';
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
            'payment_method_type',
            'status',
            'payment_method_name',
            'gift_card_code',
            'total_paid',
            'created_at',
            'updated_at',
        ];
    }
}