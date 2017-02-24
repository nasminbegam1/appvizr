<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vizr_qualification".
 *
 * @property integer $id
 * @property string $title
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Consultant[] $consultants
 */
class Qualification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_qualification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'unique'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultants()
    {
        return $this->hasMany(Consultant::className(), ['qualification_id' => 'id']);
    }
}
