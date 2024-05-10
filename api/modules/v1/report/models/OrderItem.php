<?php

namespace api\modules\v1\report\models;

use yii\db\ActiveQuery;

class OrderItem extends \common\models\OrderItem
{
    public $quantity_order;

    public function fields(): array
    {
        return [
            "item_id",
            "quantity_order",
            "service"
        ];
    }

    public static function report(): ActiveQuery
    {
        return parent::find()
            ->select([
                'item_id',
                'COUNT(order_id) AS quantity_order',
            ])
            ->with(['service'])
            ->andWhere(['item_type' => self::TYPE_SERVICE])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->groupBy(['item_id']);
    }
}