<?php

namespace api\modules\v1\category\models\search;

use common\models\Category;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

class CategorySearch extends Category
{
    public function search($request = null): ActiveDataProvider
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
        ]);
        if (!$this->load($request, '') || !$this->validate()) {
            return $dataProvider;
        }
        $sort = new Sort([
            'attributes' => [$request['sort'] ?? 'id']
        ]);
        $dataProvider->query->orderBy($sort->getOrders());
        if (!empty($request['name'])) {
            $dataProvider->query->andFilterWhere(['LIKE', 'name', $request['name']]);
        }
        if (!empty($request['perPage'])) {
            $dataProvider->query->limit($request['perPage']);
        }
        return $dataProvider;
    }
}