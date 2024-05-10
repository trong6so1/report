<?php

namespace common\models\form;

use common\models\base\BaseOrderItem;
use common\models\OrderItem;
use yii\base\Model;

class OrderItemForm extends Model
{
    public $order_id;
    public $item_id;
    public $quantity;
    public $status;
    public $item_type;
    public $staff_id;
    public $combo_id;
    public $item_name;
    public $cancel_reason;
    public $staff_name;
    public $item_variant;
    public $item_modifier;
    public $additional_data;
    public $giftcard_data;
    public $note;
    public $owner_note;
    public $price;

    public function rules(): array
    {
        return [
            [['order_id', 'item_id', 'quantity', 'status', 'item_type', 'staff_id', 'combo_id'], 'integer'],
            [['item_name', 'cancel_reason', 'staff_name'], 'string', 'max' => 255],
            [['item_variant', 'item_modifier', 'additional_data', 'giftcard_data',
                'note', 'owner_note'], 'string'],
            ['price', 'double'],
            ['item_type', 'in', 'range' => OrderItem::getItemTypes()],
            ['item_type', 'required', 'message' => 'Item type is required when entering item id',
                'when' => function ($model) {
                return !empty($model->item_id);
            }]
        ];
    }
}