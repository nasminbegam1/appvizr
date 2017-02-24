<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;

use api\modules\v1\models\Category;
use api\modules\v1\models\SubCategory;
use api\modules\v1\models\Qualification;
use api\modules\v1\models\Customer;
use api\modules\v1\models\Consultant;
use api\modules\v1\models\Sitesettings;
use api\modules\v1\models\Callhistory;
use yii\helpers\ArrayHelper;
use yii;

class CustomerController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Customer';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'update','getlist','login','create','profilepicture','changepassword','callhistorylist','notificationlist','consultantsearch'],
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
    
    /* Customer registration*/
    public function actionCreate()
    {   
        $model = new Customer();
        $post_data = Yii::$app->request->post();
        $unique_check = false;
        if($post_data['email'] <> '') {
            $email_exist    = Customer::findOne(['email' => $post_data['email']]);
            if(count($email_exist) > 0) {
               $unique_check = true;
               return array('error' => true,'message' => 'This e-mail address already exists.');
            
            }
        } 
        if($unique_check == false){
            
            $first_name                 = $post_data['first_name'];
            $last_name                  = $post_data['last_name'];
            $email                      = $post_data['email'];
            $country_code               = $post_data['country_code'];
            $phone                      = $post_data['phone'];
            $registration_type          = $post_data['registration_type'];
            $token_id                   = $post_data['token_id'];
            $device_type                = $post_data['device_type'];
            $quickbox_id                = $post_data['quickbox_id'];
            $facebook_id                = $post_data['facebook_id'];
            
            $model->token_id            = $token_id;
            $model->device_type         = $device_type;
            $model->auth_key            = Yii::$app->security->generateRandomString();
            $model->first_name          = $first_name;
            $model->last_name           = $last_name;
            $model->email               = $email;
            $model->country_code        = $post_data['country_code'];
            $model->phone               = $phone;
            $model->password            = Yii::$app->security->generatePasswordHash($post_data['password']);
            $model->status              = 'Inactive';
            $model->profile_image       = 'no-profile.jpg';
            $model->registration_type   = $registration_type;
            $model->facebook_id         = $facebook_id;
            $model->quickbox_id         = $quickbox_id;
            $model->created_at          = date('Y-m-d H:i:s');
            $model->save();
            if(count($model->errors) > 0) {
                return $model;
            } else {
                
                $mail['first_name'] = $first_name;
                $mail['email']      = $email;
                $mail['password']   = $post_data['password'];
                $mail['auth_key']   = $model->auth_key;
                
                $mail['webmasterEmail']  = Sitesettings::findOne(10);
                $mailSend = Yii::$app->mailer->compose('@app/modules/v1/views/email/customer_registration',['model'=>$mail])
                    ->setTo($mail['email'])
                    ->setFrom([$mail['webmasterEmail']->sitesettings_value => 'appvizr'])
                    ->setSubject('Successfully register as a Customer')
                    ->send();
                    
                if($mailSend){
                    $result_array = ArrayHelper::toArray($model, [], false);
                    $result_array['message']='Thank you for registering as Customer';
                    return $result_array;
                }
            }
         } else {
            return array('error' => true,'message' => 'This e-mail address already exists.');
        }
     }
     
     /* Customer login*/
     public function actionLogin(){
        $postdata   = Yii::$app->request->post();
        $customer   = Customer::find()->where(['email' => $postdata['email']])->one();
        if(count($customer) > 0){
            if(Yii::$app->getSecurity()->validatePassword($postdata['password'], $customer->password)){
                $customer->last_login    = date('Y-m-d H:i:s');
                $customer->token_id      = $postdata['token_id'];
                $customer->device_type   = $postdata['device_type'];
                $customer->save();
                return $customer;
            }else{
                return array('error' => true,'message' => 'Please enter correct login details.');
            }
        }else{
            return array('error' => true,'message' => 'Email does not exists');
        }
    }
     
    /* Change customer profile picture*/
    public function actionProfilepicture()
    {
       $postdata    = Yii::$app->request->post();
       $id          = $postdata['id'];
       $blobImage   = $postdata['profileImage'];
       
       $model=Customer::findOne($id);
       if(count($model) > 0) {
       
            if($blobImage){
               
                   //image conversion
                  $original_path    = Yii::getAlias('@basePath').'/uploads/customer/';
                  $thumb_path       = Yii::getAlias('@basePath').'/uploads/customer/thumb/';
                    
                  $binary  = base64_decode($blobImage);
                  header('Content-Type: bitmap; charset=utf-8');

                  $f = finfo_open();
                  $mime_type = finfo_buffer($f, $binary, FILEINFO_MIME_TYPE);
                  $mime_type = str_ireplace('image/', '', $mime_type);


                  $filename = time().mt_rand(1000, 9999). '.' . $mime_type;

                  $file = fopen($original_path . $filename, 'wb');

                  if (fwrite($file, $binary)) {
                    
                    if(file_exists($original_path . $model->profile_image) && $model->profile_image != '' && $model->profile_image !='no-profile.jpg'){
                        
                        unlink($original_path . $model->profile_image);
                    }
                    if(file_exists($thumb_path . $model->profile_image) && $model->profile_image != '' && $model->profile_image !='no-profile.jpg'){
                        
                        unlink($thumb_path . $model->profile_image);
                    }
                    
                      if($mime_type == 'png') {
                         $img = imagecreatefrompng($original_path.$filename);    
                      }
                      if($mime_type == 'jpg' || $mime_type == 'jpeg') {
                         $img = imagecreatefromjpeg($original_path.$filename);    
                      }
                      if($mime_type == 'gif') {
                         $img = imagecreatefromgif($original_path.$filename);    
                      }
                      $width = imagesx( $img );
                      $height = imagesy( $img );                      

                      if($width > 200) {
                          // calculate thumbnail size
                          $new_width = 200;
                          $new_height = floor( $height * ( 200 / $width ) );

                          // create a new temporary image
                          $tmp_img = imagecreatetruecolor( $new_width, $new_height );

                          // copy and resize old image into new image 
                          //imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );
                          imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

                          // save thumbnail into a file
                          if($mime_type == 'png') {
                              imagepng( $tmp_img, "{$thumb_path}{$filename}",9);
                          }
                          if($mime_type == 'jpg' || $mime_type == 'jpeg') {
                            imagejpeg( $tmp_img, "{$thumb_path}{$filename}",100);  
                          }
                          if($mime_type == 'gif') {
                              imagegif( $tmp_img, "{$thumb_path}{$filename}",100);
                          }

                      } else {
                          copy($original_path.$filename, $thumb_path.$filename);
                      }

                      $model->profile_image = $filename; 
                      $model->save();

                    }
             } 
             
             return array('customer_details'=>$model);
             
        }
        else {
            return array('error' => true,'message' => 'Please try again. Uable to edit this image.','data'=>array());
        }
        
      } 
      
      /**
     * User Changepassword
     * @param Request $request
     * @return json response
     */
    public function actionChangepassword(){
       
       
       $request             = Yii::$app->request;
       
       $id                  = $request->post('id');
       $new_password        = $request->post('password');
       $old_password        = $request->post('old_password');
       $model               = Customer::findOne($id);
       
       if(count($model) > 0) {
        if(!Yii::$app->security->validatePassword($old_password, $model->password)) {
                return array('error' => true,'message' => 'The password does not match with your old password.');
           } else {
               $model->password = Yii::$app->security->generatePasswordHash($new_password);
               $model->save();
               return array('error' =>false,'message' => 'your password has been changed successfully.');
           }
       } else {
           return array('error' => true,'message' => 'Customer does not exsist.');
       }
       
    }
      
      public function actionCallhistorylist(){
        $request                = Yii::$app->request;
        $id                     = $request->post('id');
        $call_history           = Callhistory::find()->where(['customer_id'=>$id,'from_caller'=>'Customer'])->all();
        if(count($call_history) > 0) {
        $history             = [];
        foreach($call_history as $k=>$con){
         $history[$k]                  = ArrayHelper::toArray($con, [], false);
         $get_call_time = explode(':',$con->call_time);
         /*$hour   = ($get_call_time[0] <> '00')?$get_call_time[0]. " hr ":"";*/
         $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
         $second = ($get_call_time[1] <> '0')?intval($get_call_time[1]). " second":"";
         $call_time = $minute.$second;
         $history[$k]['first_name']          = $con->consultant->first_name;
         $history[$k]['last_name']           = $con->consultant->last_name;
         $history[$k]['email']               = $con->consultant->email;
         $history[$k]['profile_image']       = $con->consultant->profile_image;
         $history[$k]['quickbox_id']         = $con->consultant->quickbox_id;
         $history[$k]['call_start_time']     = date('h:i A', strtotime($con->call_date));
         $history[$k]['call_date']           = date('Y-m-d', strtotime($con->call_date));
         $history[$k]['call_time']     = $call_time;

        }
         return $history;
        } else {
         return array('error' => true,'message' => 'Consultant list not found');
        }
     }
     
     public function actionNotificationlist(){
        $request                = Yii::$app->request;
        $id                     = $request->post('id');
        $call_notification      = Callhistory::find()->where(['customer_id'=>$id,'from_caller'=>'Consultant'])->all();
        if(count($call_notification) > 0) {
            $notification             = [];
            foreach($call_notification as $k=>$con){
                $notification[$k]              = ArrayHelper::toArray($con, [], false);
                $get_call_time = explode(':',$con->call_time);
                /*$hour   = ($get_call_time[0] <> '00')?$get_call_time[0]. " hr ":"";*/
                $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
                $second = ($get_call_time[1] <> '0')?intval($get_call_time[1]). " second":"";
                $call_time = $minute.$second;
                $notification[$k]['first_name']          = $con->consultant->first_name;
                $notification[$k]['last_name']           = $con->consultant->last_name;
                $notification[$k]['email']               = $con->consultant->email;
                $notification[$k]['profile_image']       = $con->consultant->profile_image;
                $notification[$k]['quickbox_id']         = $con->consultant->quickbox_id;
                $notification[$k]['call_start_time']     = date('h:i A', strtotime($con->call_date));
                $notification[$k]['call_date']           = date('Y-m-d', strtotime($con->call_date));
                $notification[$k]['call_time']           = $call_time;
         }
         return $notification;
        } else {
         return array('error' => true,'message' => 'Consultant list not found');
        }
     }
     
     
      public function actionConsultantsearch(){
        $request                = Yii::$app->request;
        $id                     = $request->post('id');
        $search_str             = $request->post('search_str');
        $consultant_list        =  Consultant::find()->where(['id' => 2])->all();
        
$model = Callhistory::find()
->innerJoinWith('consultant', 'callhistory.id = consultant.id')
->andWhere(['vizr_callhistory.customer_id' => $id])
->all();

       
        
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand('SELECT *,vizr_consultant.* 
        FROM vizr_callhistory , vizr_consultant
        WHERE vizr_callhistory.id IN (
           SELECT MAX(id)
           FROM vizr_callhistory
           WHERE customer_id ="'.$id.'"
           GROUP BY consultant_id
        ) AND vizr_callhistory.consultant_id=vizr_consultant.id
          AND (vizr_consultant.first_name LIKE "%'.$search_str.'%" OR vizr_consultant.last_name LIKE "%'.$search_str.'%" OR vizr_consultant.email LIKE "%'.$search_str.'%")
          
          ');

             
        $callhistory_list = $command->queryAll();
        
       
        if(count($callhistory_list) > 0) {
            $result             = [];
            $k = 0;
            foreach($callhistory_list as $val){
                
                $get_call_time = explode(':',$val['call_time']);
                $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
                $second = ($get_call_time[1] <> '0')?intval($get_call_time[1]). " second":"";
                $call_time = $minute.$second;
                $result[$k]                        = $val;   
                $result[$k]['id']                  = intval($val['id']);  
                $result[$k]['customer_id']         = intval($val['customer_id']);   
                $result[$k]['consultant_id']       = intval($val['consultant_id']);   
                $result[$k]['cat_id']              = intval($val['cat_id']);   
                $result[$k]['sub_cat_id']          = intval($val['sub_cat_id']); 
                $result[$k]['qualification_id']    = intval($val['qualification_id']); 
                $result[$k]['quickbox_id']          = intval($val['quickbox_id']);
                $result[$k]['call_start_time']     = date('h:i A', strtotime($val['call_date']));
                $result[$k]['call_date']           = date('Y-m-d', strtotime($val['call_date']));
                $result[$k]['call_time']           = $call_time;
                $k++;
         }
         return $result;
        } else {
         return array('error' => true,'message' => 'Consultant list not found');
        }
     }

}
