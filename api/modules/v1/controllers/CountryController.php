<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;

use api\modules\v1\models\Country;
use yii\helpers\ArrayHelper;
use yii;

class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'update'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }
    
    
    
}
