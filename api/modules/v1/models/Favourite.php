<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_favourite".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $consultant_id
 * @property string $is_favourite
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Consultant $consultant
 * @property Customer $customer
 */
class Favourite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_favourite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['customer_id', 'consultant_id', 'created_at'], 'required'],
            [['customer_id', 'consultant_id'], 'integer'],
            [['is_favourite'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'customer_id' => 'Customer ID',
            'consultant_id' => 'Consultant ID',
            'is_favourite' => 'Is Favourite',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['id' => 'consultant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }
}
