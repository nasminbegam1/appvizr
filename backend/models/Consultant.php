<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vizr_consultant".
 *
 * @property integer $id
 * @property string $token_id
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
    public $sub_cat_name;
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
            [['token_id', 'first_name', 'last_name', 'email','country_code','phone', 'cat_id', 'sub_cat_id', 'qualification_id', 'description','status'], 'required'],
            [['cat_id', 'qualification_id'], 'integer'],
            [['description', 'status', 'registration_type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['token_id', 'password'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'email','country_code','phone', 'profile_image'], 'string', 'max' => 150],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
            [['qualification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualification::className(), 'targetAttribute' => ['qualification_id' => 'id']],
            [['email'], 'unique'],
            [['profile_image'],'file','extensions' => 'png, jpg'],
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
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'password' => 'Password',
            'country_code' => 'Country Code',
            'phone' => 'Phone',
            'profile_image' => 'Profile Image',
            'cat_id' => 'Category',
            'sub_cat_id' => 'Sub Category',
            'qualification_id' => 'Qualification',
            'description' => 'Description',
            'status' => 'Status',
            'registration_type' => 'Registration Type',
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
     public function getSub_cat_id(){
            //Use value from database in attributes and split into array with primary keys
            $pks = explode(",",$this->attributes['sub_cat_id']);
            //Query database
            $models = SubCategory::find()->select(['GROUP_CONCAT(DISTINCT(subcat_name) ORDER BY subcat_name ASC) as subcat_name'])->where(['IN', 'id',$pks])->one();
            return $models->subcat_name;
        }
}
