<?php

namespace common\models\form;

use yii\base\Model;

/**
 * @property mixed $id
 */
class CategoryForm extends Model
{
    public $name;
    public $status;
    public $type = 'service';
    public $image_base_url;
    public $image_path;
    public $priority;
    public $parent_id;
    public $owner_id;
    public $created_by;
    public $group_id;
    public $description;

    public function rules(): array
    {
        return [
            [['name', 'status', 'type', 'image_base_url', 'image_path'], 'string', 'max' => 255],
            [['priority', 'parent_id', 'owner_id', 'created_by', 'group_id'], 'integer'],
            ['description', 'string'],
            ['name', 'required'],
        ];
    }
}