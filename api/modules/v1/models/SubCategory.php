<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_sub_category".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $subcat_name
 * @property string $subcat_image
 * @property string $subcat_status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Category $cat
 */
class SubCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_sub_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'subcat_name', 'subcat_image', 'created_at'], 'required'],
            [['cat_id'], 'integer'],
            [['subcat_status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['subcat_name'], 'string', 'max' => 255],
            [['subcat_image'], 'string', 'max' => 150],
            [['cat_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['cat_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => 'Cat ID',
            'subcat_name' => 'Subcat Name',
            'subcat_image' => 'Subcat Image',
            'subcat_status' => 'Subcat Status',
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
}
