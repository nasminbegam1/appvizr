<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_customer".
 *
 * @property integer $id
 * @property string $token_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $profile_image
 * @property string $status
 * @property string $registration_type
 * @property string $created_at
 * @property string $updated_at
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_customer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['first_name', 'last_name', 'email', 'phone', 'password', 'profile_image', 'created_at'], 'required'],
            [['status', 'registration_type','token_id','device_type'], 'string'],
            [['created_at', 'updated_at','last_login'], 'safe'],
            [['token_id', 'password','auth_key'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'email','country_code','phone', 'profile_image'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token_id' => 'Token ID',
            'device_type' => 'Device Type',
            'auth_type' => 'Auth Key',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'country_code' => 'Country Code',
            'phone' => 'Phone',
            'password' => 'Password',
            'profile_image' => 'Profile Image',
            'status' => 'Status',
            'registration_type' => 'Registration Type',
            'last_login' => 'Last Login',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    
    public function getCallhistory()
    {
        return $this->hasMany(Callhistory::className(), ['customer_id' => 'id']);
    }
    
    public function getFavourite()
    {
        return $this->hasMany(Favourite::className(), ['customer_id' => 'id']);
    }
    
    public function getRating()
    {
        return $this->hasMany(Rating::className(), ['customer_id' => 'id']);
    }
}
