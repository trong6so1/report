<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderPaymentMethodSearch;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Yii;
use yii\base\InvalidConfigException;

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
     * @throws InvalidConfigException
     */
    public function actionExport(): array
    {
        $file = Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'writerClass' => '\PhpOffice\PhpSpreadsheet\Writer\Xls',
            'sheets' => [
                'Report Income' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => (new OrderPaymentMethodSearch())->search()->query,
                    'attributes' => [
                        'payment_method_type',
                        'quantity',
                        'total_paid'
                    ],
                ],
            ],
        ]);
        $fileName = 'export_report_income_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export report income successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export report income failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

}