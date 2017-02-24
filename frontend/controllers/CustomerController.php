<?php

namespace frontend\controllers;
use app\models\Customer;
use Yii;

class CustomerController extends \yii\web\Controller
{
    public function actionActivate($key){
        if(isset($key) && !empty($key)){
            $customer = Customer::find()->where(['auth_key'=>$key])->one();     
            if(count($customer) > 0){
                
                $customer->status = 'Active';
                
                $customer->save();
                
                $message = 'Your account has been activated, you can now login';
            }else{
                // No match -> invalid url or account has already been activated.
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
