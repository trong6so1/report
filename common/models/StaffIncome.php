<?php

namespace common\models;

use common\models\base\baseStaffIncome;
use yii\db\ActiveQuery;

/**
 *
 * @property-read ActiveQuery $staff
 */
class StaffIncome extends baseStaffIncome
{
    public function getStaff(): ActiveQuery
    {
        return $this->hasOne(Employee::Class, ['user_id' => 'staff_id']);
    }
}