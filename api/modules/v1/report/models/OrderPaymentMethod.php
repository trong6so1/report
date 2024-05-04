<?php

namespace api\modules\v1\report\models;

use yii\db\ActiveQuery;

class OrderPaymentMethod extends \common\models\OrderPaymentMethod
{

    public $quantity;

    public static function getPaymentMethodTypeTitles(): array
    {
        return [
            \common\models\OrderPaymentMethod::TYPE_CREDIT_CARD => 'Credit Card',
            \common\models\OrderPaymentMethod::TYPE_CASH => 'Cash',
            \common\models\OrderPaymentMethod::TYPE_GIFT_CARD => 'Gift Card',
            \common\models\OrderPaymentMethod::TYPE_CHECK => 'Check',
            \common\models\OrderPaymentMethod::TYPE_ACH => 'ACH',
            \common\models\OrderPaymentMethod::TYPE_EXTERNAL_CC => 'External CC',
        ];
    }

    public static function getPaymentMethodTypes(): array
    {
        return [
            \common\models\OrderPaymentMethod::TYPE_CREDIT_CARD,
            \common\models\OrderPaymentMethod::TYPE_CASH,
            \common\models\OrderPaymentMethod::TYPE_GIFT_CARD,
            \common\models\OrderPaymentMethod::TYPE_CHECK,
            \common\models\OrderPaymentMethod::TYPE_ACH,
            \common\models\OrderPaymentMethod::TYPE_EXTERNAL_CC
        ];
    }

    public function fields(): array
    {
        $fields = [
            'payment_method_title' => function ($model) {
                return self::getPaymentMethodTypeTitles()[$model->payment_method_type];
            },
            'quantity'
        ];
        return array_merge(parent::fields(), $fields);
    }

    public static function report(): ActiveQuery
    {
        return parent::find()
            ->select([
                'payment_method_type',
                'COUNT(id) as quantity',
                'SUM(total_paid) as total_paid',
            ])
            ->andWhere(['status' => 1])
            ->andwhere(['IN', 'payment_method_type', self::getPaymentMethodTypes()])
            ->groupBy(['payment_method_type']);
    }
}