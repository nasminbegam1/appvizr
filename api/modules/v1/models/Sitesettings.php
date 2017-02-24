<?php

namespace api\modules\v1\models;

use Yii;

/**
 * This is the model class for table "vizr_sitesettings".
 *
 * @property string $id
 * @property string $sitesettings_name
 * @property string $sitesettings_type
 * @property string $sitesettings_data_type
 * @property string $sitesettings_lebel
 * @property string $sitesettings_value
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Sitesettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vizr_sitesettings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sitesettings_name', 'sitesettings_type', 'sitesettings_data_type', 'sitesettings_lebel', 'sitesettings_value', 'status'], 'required'],
            [['sitesettings_type', 'sitesettings_data_type', 'sitesettings_value', 'status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['sitesettings_name', 'sitesettings_lebel'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sitesettings_name' => 'Sitesettings Name',
            'sitesettings_type' => 'Sitesettings Type',
            'sitesettings_data_type' => 'Sitesettings Data Type',
            'sitesettings_lebel' => 'Sitesettings Lebel',
            'sitesettings_value' => 'Sitesettings Value',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
