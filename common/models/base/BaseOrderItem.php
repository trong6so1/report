<?php

namespace common\models\base;

use common\models\OrderItem;
use yii\db\ActiveRecord;

class BaseOrderItem extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order_items}}';
    }

    public function rules(): array
    {
        return [
            ['order_id', 'exist', 'targetClass' => BaseOrder::class, 'targetAttribute' => ['order_id' => 'id']],
            ['item_id', 'validateItemId'],
        ];
    }

    public function validateItemId($attribute, $params)
    {
        switch ($this->item_type) {
            case 1:
                {
                    $service = BaseService::findOne(['id' => $this->$attribute]);
                    if (empty($service)) {
                        $this->addError($attribute, 'service not valid');
                    }
                }
                break;
            case 4:
                {
                    $giftCard = BaseGiftCardHistory::findOne(['gift_card_id' => $this->$attribute, 'order_id' => $this->order_id]);
                    if (empty($giftCard)) {
                        $this->addError($attribute, 'gift card not valid');
                    }
                }
                break;
        }
    }

    public function fields(): array
    {
        return [
            'id',
            'order_id',
            'item_id',
            'quantity',
            'status',
            'item_type',
            'staff_id',
            'combo_id',
            'item_name',
            'cancel_reason',
            'staff_name',
            'item_variant',
            'item_modifier',
            'additional_data',
            'giftcard_data',
            'note',
            'owner_note',
            'price',
            'created_at',
            'updated_at',
        ];
    }
}