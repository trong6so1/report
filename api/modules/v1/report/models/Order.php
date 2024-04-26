<?php

namespace api\modules\v1\report\models;

use common\models\Order as OrderAlias;
use yii\data\Sort;

class Order extends OrderAlias
{
    public static function titleViewOrderStatusReport(): array
    {
        return [
            OrderAlias::POS_STATUS_PENDING => 'POS STATUS PENDING',
            OrderAlias::POS_STATUS_PROCESSING => 'POS STATUS PROCESSING',
            OrderAlias::POS_STATUS_PAYMENT_SUCCESS => 'POS STATUS PAYMENT SUCCESS',
            OrderAlias::POS_STATUS_VOIDED => 'POS STATUS VOIDED',
            OrderAlias::POS_STATUS_TRANSACTION_SETTLED => 'POS STATUS TRANSACTION SETTLED',
            OrderAlias::POS_STATUS_REFUNDED => 'POS STATUS REFUNDED',
            OrderAlias::POS_STATUS_AWAITING_PAYMENT => 'POS STATUS AWAITING PAYMENT',
            OrderAlias::POS_STATUS_CANCELLED => 'POS STATUS CANCELLED',
            OrderAlias::POS_STATUS_SETTLEMENT_FAIL => 'POS STATUS SETTLEMENT FAIL',
            OrderAlias::POS_STATUS_MERGED => 'POS STATUS MERGED',
        ];
    }

    public static function queryOrderStatusReport(): array
    {
        return [
            OrderAlias::POS_STATUS_PENDING,
            OrderAlias::POS_STATUS_PROCESSING,
            OrderAlias::POS_STATUS_PAYMENT_SUCCESS,
            OrderAlias::POS_STATUS_VOIDED,
            OrderAlias::POS_STATUS_TRANSACTION_SETTLED,
            OrderAlias::POS_STATUS_REFUNDED,
            OrderAlias::POS_STATUS_AWAITING_PAYMENT,
            OrderAlias::POS_STATUS_CANCELLED,
            OrderAlias::POS_STATUS_SETTLEMENT_FAIL,
            OrderAlias::POS_STATUS_MERGED,
        ];
    }

    public static function report($request = null): array
    {
        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $query = parent::find()
            ->select([
                'order_status',
                'COUNT(*) as quantity',
                'SUM(total_after_discount) AS total_after_discount',
                'SUM(total_before_discount) AS total_before_discount',
                'SUM(total_cash_discount) AS total_cash_discount',
                'SUM(total_change) AS total_change',
                'SUM(tip) AS tip',
                'SUM(tax) AS tax',
                'SUM(service_fee) AS service_fee'
            ])
            ->andWhere(['customer_id' => null])
            ->andWhere(['between', 'created_at', $startTime, $endTime])
            ->andWhere(['IN', 'order_status', self::queryOrderStatusReport()])
            ->groupBy(['order_status']);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type']
        ]);
        $orders = $query->orderBy($sort->orders)->asArray()->all();
        if ($orders) {
            $title = self::titleViewOrderStatusReport();
            foreach ($orders as $key => $order) {
                $orders[$key]['status'] = $title[$order['order_status']];
            }
        }
        return $orders;
    }
}