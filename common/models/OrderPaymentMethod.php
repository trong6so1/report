<?php

namespace common\models;

use common\models\base\BaseOrderPaymentMethod;

class OrderPaymentMethod extends BaseOrderPaymentMethod
{
    const TYPE_CREDIT_CARD = 1;
    const TYPE_CASH = 2;
    const TYPE_GIFT_CARD = 3;
    const TYPE_CHECK = 4;
    const TYPE_ACH = 5;
    const TYPE_EXTERNAL_CC = 6;

    public static function getPaymentMethodTypeTitles(): array
    {
        return [
           self::TYPE_CREDIT_CARD => 'Credit Card',
           self::TYPE_CASH => 'Cash',
           self::TYPE_GIFT_CARD => 'Gift Card',
           self::TYPE_CHECK => 'Check',
           self::TYPE_ACH => 'ACH',
           self::TYPE_EXTERNAL_CC => 'External CC',
        ];
    }

    public static function getPaymentMethodTypes(): array
    {
        return [
           self::TYPE_CREDIT_CARD,
           self::TYPE_CASH,
           self::TYPE_GIFT_CARD,
           self::TYPE_CHECK,
           self::TYPE_ACH,
           self::TYPE_EXTERNAL_CC
        ];
    }
}