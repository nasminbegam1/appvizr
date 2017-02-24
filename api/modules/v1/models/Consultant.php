<?php

namespace api\modules\v1\models;

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
            //[['first_name', 'last_name', 'email', ], 'required'],
            [['cat_id', 'qualification_id'], 'integer'],
            [['email'],'unique','on'=>'createConsult'],
            [['description', 'status', 'registration_type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['token_id', 'password'], 'string', 'max' => 255],
            [['first_name', 'last_name', 'email','country_code','phone'], 'string', 'max' => 150],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
            [['qualification_id'], 'exist', 'skipOnError' => true, 'targetClass' => Qualification::className(), 'targetAttribute' => ['qualification_id' => 'id']],
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
            'cat_id' => 'Cat ID',
            'sub_cat_id' => 'Sub Cat ID',
            'qualification_id' => 'Qualification ID',
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
    
    public function getFavourite()
    {
        return $this->hasMany(Favourite::className(), ['consultant_id' => 'id']);
    }
    
    public function getRating()
    {
        return $this->hasMany(Rating::className(), ['consultant_id' => 'id']);
    }
    
    public function getCallhistory()
    {
        return $this->hasMany(Callhistory::className(), ['consultant_id' => 'id']);
    }
    
    public function getRatingsum()
    {
        return $this->hasMany(Rating::className(), ['consultant_id' => 'id'])->sum('rate');
    }
    
    public function getSubcatid(){
        $pks = explode(",",$this->attributes['sub_cat_id']);
        $models = SubCategory::find()->select(['GROUP_CONCAT(DISTINCT(subcat_name) ORDER BY subcat_name ASC) as subcat_name'])->where(['IN', 'id',$pks])->one();
        return $models->subcat_name;
    }
    
}
