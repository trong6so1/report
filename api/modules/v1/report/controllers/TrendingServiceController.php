<?php

namespace api\modules\v1\report\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\report\models\search\OrderItemSearch;
use Yii;
use yii\base\InvalidConfigException;

class TrendingServiceController extends Controller
{
    public function actionIndex(): array
    {
        $data = (new OrderItemSearch())->search(Yii::$app->request->queryParams);
        $statusCode = ApiConstant::SC_OK;
        $data = [
            'data' => $data,
        ];
        $error = null;
        $message = 'Report trending service income successfully';
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
                'Report Trending Service' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => (new OrderItemSearch())->search()->query,
                    'attributes' => [
                        "item_id",
                        "quantity_order",
                        "service.name",
                        "service.create_at",
                        "service.type",
                        "service.status",
                        "service.group_id",
                        "service.priority",
                        "service.category_id",
                        "service.onwer_id",
                        "service.price",
                        "service.note",
                        "service.point_bonus",
                        "service.duration",
                        "service.buffer_time",
                        "service.web_booking_visible",
                        "service.supply_share",
                        "service.show_on_checkin",
                        "service.show_on_booking",
                        "service.show_on_pos",
                        "service.image_base_url",
                        "service.image_path"
                    ],
                ],
            ],
        ]);
        $fileName = 'export_report_trending_service_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export report trending service successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the export process';
            $message = 'Export report trending service failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

}