<?php

namespace api\modules\v1\customer\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\customer\models\Customer;
use common\models\form\CustomerForm;
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
        $modelForm = new CustomerForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $customer = new Customer();
            $customer->setAttributes($modelForm->attributes, false);
            if ($customer->validate()) {
                if ($customer->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $customer;
                    $error = null;
                    $message = 'Create customer success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create customer failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $customer->errors;
                $message = 'Create customer failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create customer failed';
        }
        return ResultHelper::build($data, $statusCode, $error, $message);
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
                'Customer' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => Customer::find(),
                ],
            ],
        ]);
        $fileName = 'export_customer_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export customer successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export customer failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }

}