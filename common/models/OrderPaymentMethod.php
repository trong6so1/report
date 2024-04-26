<?php

namespace common\models;

use common\models\base\baseOrderPaymentMethod;

class OrderPaymentMethod extends baseOrderPaymentMethod
{
    const TYPE_CREDIT_CARD = 1;
    const TYPE_CASH = 2;
    const TYPE_GIFT_CARD = 3;
    const TYPE_CHECK = 4;
    const TYPE_ACH = 5;
    const TYPE_EXTERNAL_CC = 6;
}