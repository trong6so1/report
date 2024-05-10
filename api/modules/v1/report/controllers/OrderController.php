<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderSearch;
use common\jobs\ExportReportOrderJob;
use Yii;
use yii\base\InvalidConfigException;

class OrderController extends Controller
{
    public function actionIndex(): array
    {
        $report = (new OrderSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::STATUS_OK;
        $data = $report;
        $error = null;
        $message = "Report order successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionExport(): array
    {
        $attributes = [
            'order_status',
            'quantity',
            'tip',
            'tax',
            'service_fee',
            'total_before_discount',
            'total_after_discount',
            'total_change',
            'total_cash_discount',
        ];
        $file = Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'writerClass' => '\PhpOffice\PhpSpreadsheet\Writer\Xls',
            'sheets' => [
                'Report Order' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => (new OrderSearch())->search(Yii::$app->request->queryParams)->query,
                    'attributes' => $attributes,
                ],
            ],
        ]);
        $fileName = 'export_report_order_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/export/');
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $filePath = $fileDir . $fileName;
        if ($file->saveAs($filePath)) {
            $statusCode = ApiConstant::SC_OK;
            $data = [
                'filePath' => $filePath,
                'fileName' => $fileName,
            ];
            $error = null;
            $message = 'Export report order successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export report order failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}