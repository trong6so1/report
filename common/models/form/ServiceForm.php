<?php

namespace common\models\form;

use yii\base\Model;

class ServiceForm extends Model
{
    public $name;
    public $type;
    public $image_base_url;
    public $image_path;
    public $status;
    public $group_id;
    public $priority;
    public $category_id;
    public $onwer_id;
    public $point_bonus;
    public $duration;
    public $buffer_time;
    public $show_on_checkin;
    public $show_on_booking;
    public $show_on_pos;
    public $price;
    public $supply_share;
    public $web_booking_visible;
    public $note;
    public function rules(): array
    {
        return [
            [['name', 'type', 'image_base_url', 'image_path'], 'string', 'max' => 255],
            [['status', 'group_id', 'priority', 'category_id', 'onwer_id', 'point_bonus', 'duration',
                'buffer_time', 'show_on_checkin', 'show_on_booking', 'show_on_pos'], 'integer'],
            [['price', 'supply_share'], 'double'],
            ['web_booking_visible', 'string', 'max' => 10],
            ['note', 'string'],
            [['name'], 'required'],
            [['show_on_checkin', 'show_on_booking', 'show_on_pos'], 'default', 'value' => 1]
        ];
    }
}