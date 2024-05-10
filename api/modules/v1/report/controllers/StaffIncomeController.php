<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\StaffIncomeSearch;
use Yii;
use yii\base\InvalidConfigException;

class StaffIncomeController extends Controller
{
    public function actionIndex(): array
    {
        $data = (new StaffIncomeSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report staff income successfully';
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

    /**
     * @throws InvalidConfigException
     */
    public function actionExport(): array
    {
        $file = Yii::createObject([
            'class' => 'codemix\excelexport\ExcelFile',
            'writerClass' => '\PhpOffice\PhpSpreadsheet\Writer\Xls',
            'sheets' => [
                'Report Staff Income' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => (new StaffIncomeSearch())->search()->query,
                    'attributes' => [
                        "staff_id",
                        "income_after_discount",
                        "staff.name",
                        "staff.code",
                        "staff.created_at",
                        "staff.updated_at",
                        "staff.color_code",
                        "staff.image_url",
                        "staff.delete_image_url",
                        "staff.priority",
                        "staff.commission_type",
                        "staff.turn_priority",
                        "staff.last_turn_priority",
                        "staff.phone",
                        "staff.address",
                        "staff.nickname",
                        "staff.priority_calendar"
                    ]
                ],

            ],
        ]);
        $fileName = 'export_report_staff_income_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export report staff income successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export report staff income failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}