<?php

namespace frontend\controllers;
use app\models\Consultant;
use Yii;

class ConsultantController extends \yii\web\Controller
{
    public function actionActivate($key){
        if(isset($key) && !empty($key)){
            $consultant = Consultant::find()->where(['auth_key'=>$key])->one();     
            if(count($consultant) > 0){
                $consultant->status = 'Active';
                $consultant->save();
                
                $message = 'Your account has been activated, you can now login';
            }else{
                
                $message = 'The url is either invalid or you already have activated your account.';
            }
                         
        }else{
            $message = 'Invalid approach, please use the link that has been send to your email.';
        }
        return $this->render('activate', [
                    'message' => $message,
                ]);
    }
}
