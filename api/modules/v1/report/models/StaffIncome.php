<?php

namespace api\modules\v1\report\models;

use yii\db\ActiveQuery;

class StaffIncome extends \common\models\StaffIncome
{
    public function fields(): array
    {
        return [
            "staff_id",
            "income_after_discount",
            "staff"
        ];
    }

    public static function report(): ActiveQuery
    {
        return parent::find()
            ->select([
                'staff_id',
                'SUM(income_after_discount) AS income_after_discount',
            ])
            ->with(['staff'])
            ->andWhere(['status' => 1])
            ->groupBy(['staff_id']);
    }
}