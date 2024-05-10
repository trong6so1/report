<?php

namespace common\models;

use common\models\base\BaseOrderItem;
use yii\db\ActiveQuery;

/**
 *
 * @property-read ActiveQuery $service
 */
class OrderItem extends BaseOrderItem
{
    const TYPE_SERVICE = 1;
    const TYPE_PRODUCT = 2;
    const TYPE_GIFT_CARD = 4;
    const STATUS_ACTIVE = 1;

    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::Class, ['id' => 'item_id']);
    }

    public static function getItemTypes(): array
    {
        return [
            self::TYPE_SERVICE,
            self::TYPE_PRODUCT,
            self::TYPE_GIFT_CARD,
        ];
    }
}