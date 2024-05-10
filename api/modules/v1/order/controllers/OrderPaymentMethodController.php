<?php

namespace api\modules\v1\order\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\order\models\OrderPaymentMethod;
use common\models\form\OrderPaymentMethodForm;
use Yii;
use yii\base\InvalidConfigException;
use yii\db\Exception;

class OrderPaymentMethodController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $modelForm = new OrderPaymentMethodForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $order = new OrderPaymentMethod();
            $order->setAttributes($modelForm->attributes, false);
            if ($order->validate()) {
                if ($order->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $order;
                    $error = null;
                    $message = 'Create order payment method success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create order payment method failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $order->errors;
                $message = 'Create order payment method failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create order payment method failed';
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
                'Order Payment Method' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => OrderPaymentMethod::find(),
                ],
            ],
        ]);
        $fileName = 'export_order_payment_method_' . date('YmdHis') . '.xlsx';
        $fileDir = Yii::getAlias('@app/search/');
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
            $message = 'Export order payment method successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export order payment method failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}