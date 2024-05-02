<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderItemSearch;
use Yii;

class TrendingServiceController extends Controller
{
    public function actionIndex(): array
    {
        $data = OrderItemSearch::search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report trending service income successfully';
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}