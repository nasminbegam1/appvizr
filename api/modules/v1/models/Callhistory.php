<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_callhistory".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property integer $consultant_id
 * @property string $call_date
 * @property string $call_time
 * @property string $from_caller
 * @property string $call_type
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Customer $customer
 * @property Consultant $consultant
 */
class Callhistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_callhistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'consultant_id', 'call_date', 'call_time', 'from_caller', 'call_type'], 'required'],
            [['customer_id', 'consultant_id'], 'integer'],
            [['call_date', 'created_at', 'updated_at'], 'safe'],
            [['from_caller', 'call_type'], 'string'],
            [['call_time'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['consultant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Consultant::className(), 'targetAttribute' => ['consultant_id' => 'id']],
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
            'call_date' => 'Call Date',
            'call_time' => 'Call Time',
            'from_caller' => 'From Caller',
            'call_type' => 'Call Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConsultant()
    {
        return $this->hasOne(Consultant::className(), ['id' => 'consultant_id']);
    }
}
