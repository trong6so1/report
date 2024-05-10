<?php

namespace common\models\form;

use yii\base\Model;

class OrderTipForm extends Model
{
    public $order_id;
    public $status;
    public $is_updated;
    public $total_tip;
    public $tip_type;
    public $payment_method;
    public $giftcard_code;
    public $data;
    public $data_after_charge;

    public function rules(): array
    {
        return [
            [['order_id', 'status', 'is_updated'], 'integer'],
            [['total_tip'], 'double'],
            [['tip_type', 'payment_method', 'giftcard_code'], 'string', 'max' => 255],
            [['data', 'data_after_charge'], 'string']
        ];
    }
}