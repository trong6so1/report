<?php

namespace common\models\form;

use common\models\OrderPaymentMethod;
use yii\base\Model;

class OrderPaymentMethodForm extends Model
{
    public $order_id;
    public $payment_method_type;
    public $status;
    public $payment_method_name;
    public $gift_card_code;
    public $total_paid;
    public function rules(): array
    {
        return [
            [['order_id', 'payment_method_type', 'status'], 'integer'],
            ['payment_method_name', 'string', 'max' => 100],
            ['gift_card_code', 'string', 'max' => 255],
            ['total_paid', 'double'],
            ['payment_method_type', 'in', 'range' => OrderPaymentMethod::getPaymentMethodTypes()]
        ];
    }
}