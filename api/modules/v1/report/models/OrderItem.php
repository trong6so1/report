<?php

namespace api\modules\v1\report\models;

use yii\data\Sort;

class OrderItem extends \common\models\OrderItem
{
    public static function report($request = null): array
    {
        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $query = self::find()
            ->select([
                'item_id',
                'COUNT(order_id) AS quantity_order',
            ])
            ->with(['service'])
            ->andWhere(['between', 'created_at', $startTime, $endTime])
            ->andWhere(['item_type' => self::TYPE_SERVICE])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->groupBy(['item_id']);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type']
        ]);
        return $query->orderBy($sort->orders)->asArray()->all();
    }
}