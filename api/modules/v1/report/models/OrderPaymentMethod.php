<?php

namespace api\modules\v1\report\models;


use yii\data\Sort;

class OrderPaymentMethod extends \common\models\OrderPaymentMethod
{

    public static function viewPaymentMethodTypeReport(): array
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

    public static function queryPaymentMethodTypeReport(): array
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

    public static function report($request = null): array
    {
        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $query = self::find()
            ->select([
                'payment_method_type',
                'COUNT(id) as quantity',
                'SUM(total_paid) as total_paid',
            ])
            ->andWhere(['status' => 1])
            ->andWhere(['between', 'created_at', $startTime, $endTime])
            ->andwhere(['IN', 'payment_method_type', self::queryPaymentMethodTypeReport()])
            ->groupBy(['payment_method_type']);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type']
        ]);
        $orders = $query->orderBy($sort->orders)->asArray()->all();
        if (!empty($orders)) {
            $title = self::viewPaymentMethodTypeReport();
            foreach ($orders as $key => $order) {
                $orders[$key]['payment_method_name'] = $title[$order['payment_method_type']];
            }
        }
        return $orders;
    }
}