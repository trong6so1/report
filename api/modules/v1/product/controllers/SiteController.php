<?php

namespace api\modules\v1\product\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\product\models\Product;
use common\models\form\ProductForm;
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
        $modelForm = new ProductForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $product = new Product();
            $product->setAttributes($modelForm->attributes, false);
            if ($product->validate()) {
                if ($product->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $product;
                    $error = null;
                    $message = 'Create product success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create product failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $product->errors;
                $message = 'Create product failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create product failed';
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
                'Product' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => Product::find(),
                ],
            ],
        ]);
        $fileName = 'export_product_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export product successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export product failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}