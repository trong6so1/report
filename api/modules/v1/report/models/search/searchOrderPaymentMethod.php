<?php

namespace api\modules\v1\report\models\search;

use api\modules\v1\report\models\OrderPaymentMethod;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class searchOrderPaymentMethod
{
    public static function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => OrderPaymentMethod::report()->asArray(),
            'pagination' => [
                'pageSize' => $request['perPage'] ?? 10,
            ],
            'key' => 'payment_method_type'
        ]);

        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $dataProvider->query->andFilterWhere(['between', 'created_at', $startTime, $endTime]);

        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type'],
        ]);
        $dataProvider->query->orderBy($sort->orders);
        $paymentMethodTypeTitles = OrderPaymentMethod::getPaymentMethodTypeTitles();

        $dataProvider->setModels(array_map(function ($model) use ($paymentMethodTypeTitles) {
            $model['payment_method'] = $paymentMethodTypeTitles[$model['payment_method_type']];
            return $model;
        }, $dataProvider->getModels()));

        return $dataProvider;
    }
}