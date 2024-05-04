<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderSearch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

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

    public function actionExport()
    {
        $request = Yii::$app->request->queryParams;
        $request['perPage'] = false;
        $dataProvider = (new OrderSearch())->search($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Order Status' => 'order_status',
            'Order Status Title' => 'order_status_title',
            'Quantity' => 'quantity',
            'Tip' => 'tip',
            'Tax' => 'tax',
            'Total Before Discount' => 'total_before_discount',
            'Total After Discount' => 'total_after_discount',
            'Total Change' => 'total_change',
            'Total Cash Discount' => 'total_cash_discount',
            'Service Fee' => 'service_fee',
        ];
        $sheet->fromArray(array_keys($headers), null, 'A1');

        $row = 2;
        foreach ($dataProvider->getModels() as $value) {
            $rowData = [];
            foreach ($headers as $field) {
                $rowData[] = $value->$field;
            }
            $sheet->fromArray($rowData, null, 'A' . $row);
            $row++;
        }

        $filename = 'report_order_' . date('YmdHis') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        $tempDir = Yii::getAlias('@web/exports/');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        $filePath = $tempDir . $filename;
        $writer->save($filePath);

        Yii::$app->response->sendFile($filePath)->send();
        unset($filePath);
    }
}