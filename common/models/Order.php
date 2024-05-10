<?php

namespace common\models;

use common\models\base\BaseOrder;

/**
 *
 * @property-read string $orderStatusTitles
 */
class Order extends BaseOrder
{
    const POS_STATUS_PENDING = 11;
    const POS_STATUS_PROCESSING = 12;
    const POS_STATUS_PAYMENT_SUCCESS = 13;
    const POS_STATUS_VOIDED = 14;
    const POS_STATUS_TRANSACTION_SETTLED = 15;
    const POS_STATUS_REFUNDED = 16;
    const POS_STATUS_AWAITING_PAYMENT = 17;
    const POS_STATUS_CANCELLED = 19;
    const POS_STATUS_SETTLEMENT_FAIL = 20;
    const POS_STATUS_MERGED = 21;

    public static function getOrderStatusTitles(): array
    {
        return [
            self::POS_STATUS_PENDING => 'POS STATUS PENDING',
            self::POS_STATUS_PROCESSING => 'POS STATUS PROCESSING',
            self::POS_STATUS_PAYMENT_SUCCESS => 'POS STATUS PAYMENT SUCCESS',
            self::POS_STATUS_VOIDED => 'POS STATUS VOIDED',
            self::POS_STATUS_TRANSACTION_SETTLED => 'POS STATUS TRANSACTION SETTLED',
            self::POS_STATUS_REFUNDED => 'POS STATUS REFUNDED',
            self::POS_STATUS_AWAITING_PAYMENT => 'POS STATUS AWAITING PAYMENT',
            self::POS_STATUS_CANCELLED => 'POS STATUS CANCELLED',
            self::POS_STATUS_SETTLEMENT_FAIL => 'POS STATUS SETTLEMENT FAIL',
            self::POS_STATUS_MERGED => 'POS STATUS MERGED',
        ];
    }

    public static function getOrderStatuses(): array
    {
        return [
            self::POS_STATUS_PENDING,
            self::POS_STATUS_PROCESSING,
            self::POS_STATUS_PAYMENT_SUCCESS,
            self::POS_STATUS_VOIDED,
            self::POS_STATUS_TRANSACTION_SETTLED,
            self::POS_STATUS_REFUNDED,
            self::POS_STATUS_AWAITING_PAYMENT,
            self::POS_STATUS_CANCELLED,
            self::POS_STATUS_SETTLEMENT_FAIL,
            self::POS_STATUS_MERGED,
        ];
    }

}