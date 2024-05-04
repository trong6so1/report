<?php

namespace api\modules\v1\report\models;

use common\models\Order as OrderAlias;
use yii\db\ActiveQuery;

/**
 *
 * @property-read void $status
 * @property mixed|null $order_status
 */
class Order extends OrderAlias
{
    public $quantity;
    public $order_status_title;

    public static function getOrderStatusTitles(): array
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

    public static function getOrderStatuses(): array
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

    public function fields(): array
    {
        $fields = [
            'order_status_title',
            'quantity'
        ];
        return array_merge(parent::fields(), $fields);
    }

    public static function report(): ActiveQuery
    {
        return parent::find()
            ->select([
                'order_status',
                'COUNT(*) AS quantity',
                'SUM(total_after_discount) AS total_after_discount',
                'SUM(total_before_discount) AS total_before_discount',
                'SUM(total_cash_discount) AS total_cash_discount',
                'SUM(total_change) AS total_change',
                'SUM(tip) AS tip',
                'SUM(tax) AS tax',
                'SUM(service_fee) AS service_fee',
            ])
            ->andWhere(['customer_id' => null])
            ->andWhere(['IN', 'order_status', self::getOrderStatuses()])
            ->groupBy(['order_status']);
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->order_status_title = self::getOrderStatusTitles()[$this->order_status];
    }
}