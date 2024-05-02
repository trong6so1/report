<?php

namespace common\models;

use common\models\base\BaseOrder;

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
}