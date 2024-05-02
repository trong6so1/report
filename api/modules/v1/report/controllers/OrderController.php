<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\searchOrder;
use Yii;

class OrderController extends Controller
{
    public function actionIndex(): array
    {
        $report = searchOrder::search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::STATUS_OK;
        $data = $report;
        $error = null;
        $message = "Report order successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}