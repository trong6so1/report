<?php

namespace api\modules\v1\category\controllers;

use api\helper\response\ApiConstant;
use api\helper\response\ResultHelper;
use api\modules\v1\category\models\Category;
use api\modules\v1\category\models\search\CategorySearch;
use common\models\form\CategoryForm;
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
        $modelForm = new CategoryForm();
        $modelForm->load(Yii::$app->request->post(), '');
        if ($modelForm->validate()) {
            $category = new Category();
            $category->setAttributes($modelForm->attributes, false);
            if ($category->validate()) {
                if ($category->save()) {
                    $statusCode = ApiConstant::SC_OK;
                    $data = $category;
                    $error = null;
                    $message = 'Create category success';
                } else {
                    $statusCode = ApiConstant::SC_EXCEPTION;
                    $data = null;
                    $error = 'There was an error during the adding process';
                    $message = 'Create category failed';
                }
            } else {
                $statusCode = ApiConstant::SC_BAD_REQUEST;
                $data = null;
                $error = $category->errors;
                $message = 'Create category failed';
            }
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = $modelForm->errors;
            $message = 'Create category failed';
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
                'Category' => [
                    'class' => 'codemix\excelexport\ActiveExcelSheet',
                    'query' => (new CategorySearch())->search(Yii::$app->request->queryParams)->query,
                ],
            ],
        ]);
        $fileName = 'export_category_' . date('YmdHis') . '.xlsx';
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
            $message = 'Export category successfully';
        } else {
            $statusCode = ApiConstant::SC_BAD_REQUEST;
            $data = null;
            $error = 'There was an error during the search process';
            $message = 'Export category failed';
        }
        return ResultHelper::build($statusCode, $data, $error, $message);
    }
}