<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_category".
 *
 * @property integer $id
 * @property string $cat_name
 * @property string $cat_image
 * @property string $cat_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Consultant[] $consultants
 * @property SubCategory[] $subCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_name', 'cat_image', 'created_at'], 'required'],
            [['cat_status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['cat_name'], 'string', 'max' => 255],
            [['cat_image'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_name' => 'Cat Name',
            'cat_image' => 'Cat Image',
            'cat_status' => 'Cat Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultants()
    {
        return $this->hasMany(Consultant::className(), ['cat_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::className(), ['cat_id' => 'id']);
    }
}
