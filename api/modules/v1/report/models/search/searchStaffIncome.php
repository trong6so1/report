<?php

namespace api\modules\v1\report\models\search;

use api\modules\v1\report\models\StaffIncome;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class searchStaffIncome
{
    public static function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => StaffIncome::report()->asArray(),
            'pagination' => [
                'pageSize' => $request['perPage'] ?? 10,
            ],
            'key' => 'staff_id'
        ]);

        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $dataProvider->query->andFilterWhere(['between', 'created_at', $startTime, $endTime]);

        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'payment_method_type']
        ]);
        $dataProvider->query->orderBy($sort->orders);
        return $dataProvider;
    }
}