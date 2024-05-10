<?php

namespace common\models\form;

use common\models\Order;
use yii\base\Model;

class OrderForm extends Model
{
    public $order_code;
    public $customer_id;
    public $employee_id;
    public $order_status;
    public $status;
    public $checkin_id;
    public $is_waiting;
    public $is_recheck;
    public $pax_standalone_active;
    public $ach_payment_active;
    public $is_tip_on_device;
    public $tip_by_credit_card;
    public $external_credit_card;
    public $in_service;
    public $customer_name;
    public $employee_name;
    public $qr_code;
    public $custom;
    public $customer_phone;
    public $customer_email;
    public $payment_method;
    public $currency;
    public $promotion_code;
    public $type;
    public $cancel_reason;
    public $customer_address;
    public $note;
    public $owner_note;
    public $ach_payment_data;
    public $attachment;
    public $start_time;
    public $expected_end_time;
    public $end_time;
    public $picked_up_time;
    public $delivered_time;
    public $completed_time;
    public $total_before_discount;
    public $total_after_discount;
    public $total_change;
    public $tip;
    public $tax;
    public $gift_card_price;
    public $total_cash_discount;
    public $service_fee;

    public function rules(): array
    {
        return [
            [['order_code'], 'string', 'max' => 32],
            [['customer_id', 'employee_id', 'order_status', 'status', 'checkin_id', 'is_waiting',
                'is_recheck', 'pax_standalone_active', 'ach_payment_active', 'is_tip_on_device',
                'tip_by_credit_card', 'external_credit_card', 'in_service'], 'integer'],
            [['customer_name', 'employee_name', 'qr_code', 'custom'], 'string', 'max' => 255],
            [['customer_phone', 'customer_email', 'payment_method', 'currency', 'promotion_code',
                'type', 'cancel_reason'], 'string', 'max' => 100],
            [['customer_address', 'note', 'owner_note', 'ach_payment_data', 'attachment'], 'string'],
            [['start_time', 'expected_end_time', 'end_time', 'picked_up_time'],
                'datetime', 'format' => 'php:Y-m-d H:i:s'],
            [['delivered_time', 'completed_time'], 'date', 'format' => 'php:Y-m-d'],
            [['total_before_discount', 'total_after_discount', 'total_change', 'tip', 'tax',
                'gift_card_price', 'total_cash_discount', 'service_fee'], 'double'],
            ['order_status', 'in', 'range' => Order::getOrderStatuses()],
            ['customer_email', 'email']
        ];
    }
}