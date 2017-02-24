<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vizr_consultant".
 *
 * @property integer $id
 * @property string $token_id
 * @property string $device_type
 * @property string $auth_key
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $phone
 * @property string $profile_image
 * @property integer $cat_id
 * @property string $sub_cat_id
 * @property integer $qualification_id
 * @property string $description
 * @property string $status
 * @property string $registration_type
 * @property string $last_login
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $cat
 * @property Qualification $qualification
 */
class Consultant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_consultant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['token_id', 'device_type', 'auth_key', 'first_name', 'last_name', 'email', 'password', 'phone', 'profile_image', 'cat_id', 'sub_cat_id', 'qualification_id', 'description', 'last_login', 'created_at'], 'required'],
            [['device_type', 'description', 'status', 'registration_type'], 'string'],
            [['cat_id', 'qualification_id'], 'integer'],
            [['last_login', 'created_at', 'updated_at'], 'safe'],
            [['token_id', 'auth_key', 'password'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'email', 'phone', 'profile_image', 'sub_cat_id'], 'string', 'max' => 150],
            //[['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
            //[['qualification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualification::className(), 'targetAttribute' => ['qualification_id' => 'id']],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'phone' => 'Phone',
            'profile_image' => 'Profile Image',
            'cat_id' => 'Cat ID',
            'sub_cat_id' => 'Sub Cat ID',
            'qualification_id' => 'Qualification ID',
            'description' => 'Description',
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
    public function getCat()
    {
        return $this->hasOne(Category::className(), ['id' => 'cat_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQualification()
    {
        return $this->hasOne(Qualification::className(), ['id' => 'qualification_id']);
    }
}
