<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vizr_pricerange".
 *
 * @property integer $id
 * @property integer $start_price
 * @property integer $end_price
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Pricerange extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_pricerange';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_price', 'end_price', 'status'], 'required'],
            [['start_price', 'end_price'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_price' => 'Starting Price',
            'end_price' => 'Ending Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
