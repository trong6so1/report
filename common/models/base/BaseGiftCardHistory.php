<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseGiftCardHistory extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%gift_card_history}}';
    }
}