<?php

namespace common\models\base;

use yii\db\ActiveRecord;

class BaseCustomer extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%customer}}';
    }
    public function rules(): array
    {
        return [
            ['phone', 'unique', 'targetAttribute' => ['phone']],
            ['email', 'unique', 'targetAttribute' => ['email']],
        ];
    }
    public function fields(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'full_name',
            'phone',
            'email',
            'address',
            'city',
            'state',
            'country',
            'gender',
            'image_url',
            'address2',
            'postal_code',
            'source',
            'status',
            'group_id',
            'parent_id',
            'is_yelp',
            'visit_count',
            'is_send_sms',
            'is_import',
            'is_checked_in',
            'is_blocked_from_booking',
            'note',
            'rating',
            'reachable_email',
            'reachable_push',
            'reachable_sms',
            'last_visited',
            'birthday',
            'create_at',
            'update_at',
        ];
    }

}