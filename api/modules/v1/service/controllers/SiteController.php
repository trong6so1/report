<?php

namespace api\modules\v1\service\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\service\models\Service;
use common\models\form\ServiceForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new ServiceForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $service = new Service();
            $service->setAttributes($modelForm->attributes, false);
            if ($service->validate()) {
                if ($service->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $service;
                    $error = null;
                    $message = 'Create service success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create service failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $service->errors;
                $message = 'Create service failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create service failed';
        }
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
                'Report Order' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => Service::find(),
                ],
            ],
        ]);
        $fileName = 'export_service_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export service successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export service failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}