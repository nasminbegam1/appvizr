<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;
use api\modules\v1\models\Consultant;
use api\modules\v1\models\Customer;
use api\modules\v1\models\Callhistory;
use yii\helpers\ArrayHelper;
use yii;

class CallhistoryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Category';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'update','create'],
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
    
    public function actionCreate(){
        
        $model              = new Callhistory();
        $request            = Yii::$app->request;
        $consultant_id      = $request->post('consultant_id');
        $customer_id        = $request->post('customer_id');
        $call_date          = $request->post('call_date');
        $call_time          = $request->post('call_time');
        $from_caller        = $request->post('from_caller');
        $call_type          = $request->post('call_type'); //date('Y-m-d H:i:s');
        $consultant         = Consultant::findOne($consultant_id);
        $customer           = Customer::findOne($customer_id);
        
        if(count($consultant) > 0) {
            
            if(count($customer) > 0) {
                $model->customer_id     = $customer_id;
                $model->consultant_id   = $consultant_id;
                $model->call_date       = $call_date;
                $model->call_time       = $call_time;
                $model->from_caller     = $from_caller;
                $model->call_type       = $call_type;
                $model->created_at      = date('Y-m-d H:i:s');
                $model->save();
                
                $result = ArrayHelper::toArray($model, [], false);
                $get_call_time = explode(':',$call_time);
                /*$hour   = ($get_call_time[0] <> '00')?$get_call_time[0]. " hr ":"";*/
                $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
                $second = ($get_call_time[1] <> '0')?$get_call_time[1]. " second":"";
                $call_time = $minute.$second;
                $result['call_time'] = $call_time;
                return $result; 
             } 
             else {
                return array('error' => true,'message' => 'Customer not found');
            }
            
        } else {
            
            return array('error' => true,'message' => 'Consultant not found');
        }
        
        
    }
    
}
