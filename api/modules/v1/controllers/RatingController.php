<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;
use api\modules\v1\models\Rating;
use yii\helpers\ArrayHelper;
use yii;

class RatingController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Rating';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'create','totalrate'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }
    public function actionCreate()
    {   $request                = Yii::$app->request;
        $model                  = new Rating();
        $model->customer_id     = $request->post('customer_id');
        $model->consultant_id   = $request->post('consultant_id');
        $model->rate            = $request->post('rate');
        $model->created_at      = date('Y-m-d H:i:s');
        $model->save();
        return $model;
        
    }
    
    public function actionTotalrate(){
        $request                = Yii::$app->request;
        $consultant_id          = $request->post('consultant_id');
        $avgRate                = 0;
        $totalRating            = Rating::find()->where(['consultant_id'=>$consultant_id])->sum('rate');
        $totalRow               = Rating::find()->where(['consultant_id'=>$consultant_id])->count();
        if($totalRow > 0){
            $avgRate                = $totalRating/$totalRow;
            $data['consultant_id']  = (int)$consultant_id;
            $data['rating']         = $avgRate;
            return $data;
        } else {
            return array('error' => true,'message'=>'Rating not found');
        } 
        
    }
}
