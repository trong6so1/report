<?php

namespace api\modules\v1\order\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\order\models\Order;
use common\models\form\OrderForm;
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
        $modelForm = new OrderForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $order = new Order();
            $order->setAttributes($modelForm->attributes, false);
            if ($order->validate()) {
                if ($order->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $order;
                    $error = null;
                    $message = 'Create order success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create order failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $order->errors;
                $message = 'Create order failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create order failed';
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
                'Order' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => Order::find(),
                ],
            ],
        ]);
        $fileName = 'export_order_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export order successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export order failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}