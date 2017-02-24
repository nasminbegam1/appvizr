<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;

use api\modules\v1\models\Qualification;
use yii\helpers\ArrayHelper;
use yii;

class QualificationController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Qualification';
    
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
