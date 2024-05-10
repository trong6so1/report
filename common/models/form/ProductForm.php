<?php

namespace common\models\form;

use yii\base\Model;

class ProductForm extends Model
{
    public $name;
    public $image_url;
    public $type;
    public $status;
    public $price;
    public function rules(): array
    {
        return [
            [['name', 'image_url'], 'string', 'max' => 255],
            [['type', 'status'], 'integer'],
            ['price', 'double'],
            ['name', 'required']
        ];
    }
}