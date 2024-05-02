<?php

namespace api\modules\v1\report\models\search;

use api\modules\v1\report\models\Order;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class searchOrder
{
    public static function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::report()->asArray(),
            'pagination' => [
                'pageSize' => $request['perPage'] ?? 10,
            ],
            'key' => 'order_status',
        ]);

        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $dataProvider->query->andFilterWhere(['between', 'created_at', $startTime, $endTime]);

        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'order_status']
        ]);
        $dataProvider->query->orderBy($sort->orders);
        $orderStatusTitles = Order::getOrderStatusTitles();

        $dataProvider->setModels(array_map(function ($model) use ($orderStatusTitles) {
            $model['status'] = $orderStatusTitles[$model['order_status']];
            return $model;
        }, $dataProvider->getModels()));
        return $dataProvider;
    }
}