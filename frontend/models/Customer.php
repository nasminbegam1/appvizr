<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vizr_customer".
 *
 * @property integer $id
 * @property string $token_id
 * @property string $device_type
 * @property string $auth_key
 * @property integer $quickbox_id
 * @property string $facebook_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $profile_image
 * @property string $status
 * @property string $registration_type
 * @property string $last_login
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Favourite[] $favourites
 * @property Rating[] $ratings
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
            //[['token_id', 'device_type', 'auth_key', 'quickbox_id', 'facebook_id', 'first_name', 'last_name', 'email', 'phone', 'password', 'profile_image', 'last_login', 'created_at'], 'required'],
            [['device_type', 'status', 'registration_type'], 'string'],
            [['quickbox_id'], 'integer'],
            [['last_login', 'created_at', 'updated_at'], 'safe'],
            [['token_id', 'password'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 250],
            [['facebook_id', 'first_name', 'last_name', 'email', 'phone', 'profile_image'], 'string', 'max' => 150],
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
            'auth_key' => 'Auth Key',
            'quickbox_id' => 'Quickbox ID',
            'facebook_id' => 'Facebook ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFavourites()
    {
        return $this->hasMany(Favourite::className(), ['customer_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRatings()
    {
        return $this->hasMany(Rating::className(), ['customer_id' => 'id']);
    }
}
