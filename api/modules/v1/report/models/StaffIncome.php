<?php

namespace api\modules\v1\report\models;

use yii\data\Sort;

class StaffIncome extends \common\models\StaffIncome
{
    public static function report($request = null): array
    {
        $today = date('Y-m-d');
        $startTime = $request['startTime'] ?? date('Y-m-d', strtotime('-1 month', strtotime($today)));
        $endTime = $request['endTime'] ?? $today;
        $query = self::find()
            ->select([
                'staff_id',
                'SUM(income_after_discount) AS income_after_discount',
            ])
            ->with(['staff'])
            ->andWhere(['status' => 1])
            ->andWhere(['between', 'created_at', $startTime, $endTime])
            ->groupBy(['staff_id']);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'staff_id']
        ]);
        return $query->orderBy($sort->orders)->asArray()->all();
    }
}