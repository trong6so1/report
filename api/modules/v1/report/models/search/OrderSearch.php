<?php

namespace api\modules\v1\report\models\search;

use api\modules\v1\report\models\Order;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class OrderSearch extends Order
{
    public $startTime;
    public $endTime;

    public function rules(): array
    {
        return [
            [['startTime', 'endTime'], 'date', 'format' => 'php:Y-m-d'],
            ['startTime', 'default', 'value' => date('Y-m-d', strtotime('-1 month'))],
            ['endTime', 'default', 'value' => date('Y-m-d')],
        ];
    }

    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::report(),
            'pagination' => [
                'pageSize' => $request['perPage'] ?? 10,
            ],
            'key' => 'order_status',
        ]);

        if (!$this->load($request, '') || !$this->validate()) {
            $dataProvider->query->andFilterWhere(['between', 'created_at',
                date('Y-m-d', strtotime('-1 month')), date('Y-m-d')]);
            return $dataProvider;
        }
        $dataProvider->query->andFilterWhere(['between', 'created_at', $this->startTime, $this->endTime]);
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'order_status']
        ]);
        $dataProvider->query->orderBy($sort->orders);

        return $dataProvider;
    }
}