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
    const STATUS_ACTIVE = 1;

    public function getService(): ActiveQuery
    {
        return $this->hasOne(Service::Class, ['id' => 'item_id']);
    }

    public function fields(): array
    {
        return array_merge(parent::fields(), ['service']);
    }
}