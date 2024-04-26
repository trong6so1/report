<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\StaffIncome;
use Yii;

class StaffIncomeController extends Controller
{
    public function actionIndex(): array
    {
        $data = StaffIncome::report(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report staff income successfully';
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}