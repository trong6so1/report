<?php

namespace common\models\form;

use yii\base\Model;

class CustomerForm extends Model
{
    public $first_name;
    public $last_name;
    public $full_name;
    public $phone;
    public $email;
    public $address;
    public $city;
    public $state;
    public $country;
    public $gender;
    public $image_url;
    public $address2;
    public $postal_code;
    public $source;
    public $status;
    public $group_id;
    public $parent_id;
    public $is_yelp;
    public $visit_count;
    public $is_send_sms;
    public $is_import;
    public $is_checked_in;
    public $is_blocked_from_booking;
    public $note;
    public $rating;
    public $reachable_email;
    public $reachable_push;
    public $reachable_sms;
    public $last_visited;
    public $birthday;

    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'full_name', 'phone', 'email', 'address', 'city', 'state', 'country',
                'gender', 'image_url', 'address2', 'postal_code', 'source'], 'string', 'max' => 255],
            [['status', 'group_id', 'parent_id', 'is_yelp', 'visit_count', 'is_send_sms', 'is_import',
                'is_checked_in', 'is_blocked_from_booking'], 'integer'],
            ['note', 'string'],
            ['rating', 'integer', 'integerOnly' => false],
            [['reachable_email', 'reachable_push', 'reachable_sms'], 'integer', 'max' => 255],
            ['last_visited', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
            ['birthday', 'date', 'format' => 'php:Y-m-d', 'max' => date('Y-m-d')],
            [['reachable_email', 'reachable_push', 'reachable_sms', 'visit_count', 'is_send_sms'], 'default', 'value' => 1],
            [['phone', 'reachable_email', 'reachable_push', 'reachable_sms', 'visit_count'], 'required'],
            ['is_import', 'default', 'value' => 0],
            ['email', 'email'],
        ];
    }
}