<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderPaymentMethodSearch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;

class IncomeController extends Controller
{
    public function actionIndex(): array
    {
        $report = (new OrderPaymentMethodSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::STATUS_OK;
        $data = $report;
        $error = null;
        $message = "Report income successfully";
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws Exception
     */
    public function actionExport()
    {
        $request = Yii::$app->request->queryParams;
        $request['perPage'] = false;
        $dataProvider = (new OrderPaymentMethodSearch())->search($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = [
            'Payment Method Type' => 'payment_method_type',
            'Payment Method Title' => 'payment_method_title',
            'Quantity' => 'quantity',
            'Total Paid' => 'total_paid',
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