<?php

namespace common\models\base;

use yii\db\ActiveRecord;

/**
 * @property mixed|null $type
 */
class BaseOrder extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    public function rules(): array
    {
        return [
            ['customer_id', 'exist', 'targetClass' => BaseCustomer::class, 'targetAttribute' => ['customer_id' => 'id']],
            ['checkin_id', 'exist', 'targetClass' => BaseCustomerCheckin::class,
                'targetAttribute' => ['checkin_id' => 'id', 'customer_id' => 'customer_id']],
            ['employee_id', 'validateEmployeeId']
        ];
    }

    public function validateEmployeeId($attribute)
    {
        if ($this->type == "pos") {
            $this->addError($attribute, "Type pos not use employee");
        } else {
            $employee = BaseEmployee::findOne(['id' => $this->$attribute]);
            if ($employee) {
                $this->addError($attribute, "Employee Id not found");
            }
        }
    }

    public function fields(): array
    {
        return [
            'id',
            'order_code',
            'customer_id',
            'employee_id',
            'order_status',
            'status',
            'checkin_id',
            'is_waiting',
            'is_recheck',
            'pax_standalone_active',
            'ach_payment_active',
            'is_tip_on_device',
            'tip_by_credit_card',
            'external_credit_card',
            'in_service',
            'customer_name',
            'employee_name',
            'qr_code',
            'custom',
            'customer_phone',
            'customer_email',
            'payment_method',
            'currency',
            'promotion_code',
            'type',
            'cancel_reason',
            'customer_address',
            'note',
            'owner_note',
            'ach_payment_data',
            'attachment',
            'start_time',
            'expected_end_time',
            'end_time',
            'picked_up_time',
            'delivered_time',
            'completed_time',
            'total_before_discount',
            'total_after_discount',
            'total_change',
            'tip',
            'tax',
            'gift_card_price',
            'total_cash_discount',
            'service_fee',
            'created_at',
            'updated_at'
        ];
    }

}