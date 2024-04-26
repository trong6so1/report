<?php

namespace common\models;

use common\models\base\baseOrderItem;
use yii\db\ActiveQuery;

/**
 *
 * @property-read ActiveQuery $service
 */
class OrderItem extends baseOrderItem
{
    const TYPE_SERVICE = 1;
    const STATUS_ACTIVE = 1;
    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::Class, ['id' => 'item_id']);
    }
}