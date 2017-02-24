<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;
use api\modules\v1\models\Favourite;
use yii\helpers\ArrayHelper;
use yii;

class FavouriteController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Favourite';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'create', 'favouritelist'],
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
    {   
        
        $request        = Yii::$app->request;
        $unique_check   = false;
        if($request->post('customer_id') <> '' || $request->post('consultant_id') <> '') {
            $dataExist    = Favourite::findOne(['customer_id' => $request->post('customer_id'),'consultant_id' => $request->post('consultant_id')]);
            if(count($dataExist) > 0) {
               $unique_check = true;
               return $dataExist;
            }
        }
        if($unique_check == false){
            $model                  = new Favourite();
            $model->customer_id     = $request->post('customer_id');
            $model->consultant_id   = $request->post('consultant_id');
            $model->is_favourite    = 'Yes';
            $model->created_at      = date('Y-m-d H:i:s');
            $model->save();
            return $model;
        }
        
    }
    
    public function actionFavouritelist(){
        
        $request                = Yii::$app->request;
        $customer_id            = $request->post('customer_id');
        $all_fav                = Favourite::find()->where(['customer_id'=>$customer_id])->all();
        if(count($all_fav) > 0) {
        $consultent             = [];
        foreach($all_fav as $k=>$con){
            $consultent[$k]                  = ArrayHelper::toArray($con, [], false);
            $consultent[$k]['first_name']    = $con->consultant->first_name;
            $consultent[$k]['last_name']     = $con->consultant->last_name;
            $consultent[$k]['email']         = $con->consultant->email;
            $consultent[$k]['quickbox_id']   = $con->consultant->quickbox_id;
            $consultent[$k]['profile_image'] = $con->consultant->profile_image;
           
        }
            return $consultent;
        } else {
            return array('error' => true,'message' => 'Favourite list not found');
        }
    }
}
