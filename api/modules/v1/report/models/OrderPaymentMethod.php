<?php

namespace api\modules\v1\report\models;

use yii\db\ActiveQuery;

/**
 * @property mixed|null $payment_method_type
 */
class OrderPaymentMethod extends \common\models\OrderPaymentMethod
{

    public $quantity;
    public $payment_method_title;



    public function fields(): array
    {
        return [
            'payment_method_type',
            'payment_method_title' => function ($model) {
                return parent::getPaymentMethodTypeTitles()[$model->payment_method_type];
            },
            'quantity',
            'total_paid'
        ];
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
            ->andwhere(['IN', 'payment_method_type', parent::getPaymentMethodTypes()])
            ->groupBy(['payment_method_type']);
    }

}