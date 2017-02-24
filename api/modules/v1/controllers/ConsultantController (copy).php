<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

use api\modules\v1\models\Consultant;
use api\modules\v1\models\Sitesettings;
use api\modules\v1\models\SubCategory;
use api\modules\v1\models\Callhistory;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii;

class ConsultantController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Consultant';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view','create', 'update', 'consultantlogin', 'consultantprofilepicture','consultantchangepassword','setprice','consultentlist','callhistory','notification'],
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
        unset($actions['view']);
        return $actions;
    }
    
    public function actionCreate(){
        $model                      = new Consultant();
        $request                    = Yii::$app->request;
        
        $model->scenario            = 'createConsult';
        
        $model->token_id            = $request->post('token_id');
        $model->device_type         = $request->post('device_type');
        $model->auth_key            = Yii::$app->security->generateRandomString();
        $model->first_name          = $request->post('first_name');
        $model->last_name           = $request->post('last_name');
        $model->email               = $request->post('email');
        $model->password            = Yii::$app->security->generatePasswordHash($request->post('password'));
        $model->country_code        = $request->post('country_code');
        $model->phone               = $request->post('phone');
        $model->cat_id              = $request->post('cat_id');
        $model->sub_cat_id          = $request->post('sub_cat_id');
        $model->qualification_id    = $request->post('qualification_id');
        $model->description         = $request->post('description');
        $model->profile_image       = 'no-profile.jpg';
        $model->status              = 'Inactive';
        $model->registration_type   = $request->post('registration_type');
        $model->quickbox_id         = $request->post('quickbox_id');
        $model->facebook_id         = $request->post('facebook_id');
        $model->created_at          = date('Y-m-d H:i:s');
        $model->save();
        if(count($model->errors) > 0) {
            if(array_key_exists('email',$model->errors)){
                return array('error' => true,'message' => implode(',',$model->errors['email']),'data'=>[]);
            }else{
                return $model; 
            }
        } else {
            $mail['first_name'] = $request->post('first_name');
            $mail['email']      = $request->post('email');
            $mail['password']   = $request->post('password');
            $mail['auth_key']   = $model->auth_key;
            
            $mail['webmasterEmail']  = Sitesettings::findOne(10);
            
            $mailSend = Yii::$app->mailer->compose('@app/modules/v1/views/email/consultent_registration',['model'=>$mail])
                ->setTo($mail['email'])
                ->setFrom([$mail['webmasterEmail']->sitesettings_value => 'appvizr'])
                ->setSubject('Successfully register as a consultent')
                ->send();
               
            if($mailSend){
                $result_array = ArrayHelper::toArray($model, [], false);
                $result_array['message'] = 'Thank you for registering as Consultent';
                return $result_array;
            }
        }
    }
    public function actionConsultantlogin(){
        $request        = Yii::$app->request;
        $consultant     = Consultant::find()->where(['email' => $request->post('email')])->one();
        if(count($consultant) > 0){
            if(Yii::$app->getSecurity()->validatePassword($request->post('password'), $consultant->password)){
                $consultant->last_login    = date('Y-m-d H:i:s');
                $consultant->token_id      = $request->post('token_id');
                $consultant->device_type   = $request->post('device_type');
                $consultant->save();
                return $consultant;
            }else{
                return array('error' => true,'message' => 'Password not match');
            }
        }else{
            return array('error' => true,'message' => 'Please enter correct login details');
        }
    }
    
     public function actionView($id){
        $model       = Consultant::findOne($id);
        if(count($model) > 0) {
            $pks                            = explode(",",$model->sub_cat_id);
            $models_sub_category            = SubCategory::find()->select(['GROUP_CONCAT(DISTINCT(subcat_name) ORDER BY subcat_name ASC) as subcat_name'])->where(['IN', 'id',$pks])->one();
            $result_array                   = ArrayHelper::toArray($model, [], false);
            $result_array['rating']         = 0;
            $result_array['sub_category']   = $models_sub_category->subcat_name;
            $result_array['category']       = $model->cat->cat_name;
            $result_array['qualification']  = $model->qualification->title;
            if(count($model->rating) > 0){
            $result_array['rating']         = $model->ratingsum / count($model->rating);
            }
            return $result_array;
         } else {
            return array('error' => true,'message' => 'Consultant not found');
        }
     }
    public function actionConsultantprofilepicture()
    {
       $request     = Yii::$app->request;
       $id          = $request->post('id');
       $blobImage   = $request->post('profileImage');
       $model       = Consultant::findOne($id);
       if(count($model) > 0) {
       
            if($blobImage){

                  //image conversion
                  $original_path    = Yii::getAlias('@basePath').'/uploads/consultant/';
                  $thumb_path       = Yii::getAlias('@basePath').'/uploads/consultant/thumb/';
                    
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
             
             return array('consultant_details'=>$model);
             
        }
        else {
            return array('error' => true,'message' => 'Consultant not found');
        }
       
    }
    
    
    /**
     * User Changepassword
     * @param Request $request
     * @return json response
     */
    public function actionConsultantchangepassword(){
        
       $request             = Yii::$app->request;
       
       $id                  = $request->post('id');
       $new_password        = $request->post('password');
       $old_password        = $request->post('old_password');
       $model               = Consultant::findOne($id);
       
       if(count($model) > 0) {
        if(!Yii::$app->security->validatePassword($old_password, $model->password)) {
                return array('error' => true,'message' => 'The password does not match with your old password.');
           } else {
               $model->password = Yii::$app->security->generatePasswordHash($new_password);
               $model->save();
               return array('error' =>false,'message' => 'your password has been changed successfully.');
           }
       } else {
           return array('error' => true,'message' => 'Consultant does not exsist.');
       }
       
    }
    public function actionSetprice(){
       $request     = Yii::$app->request;
       $id          = $request->post('id');
       $price       = $request->post('price');
       $model       = Consultant::findOne($id);
       
       if(count($model) > 0) {
            $model->price = $price; 
            $model->save();
            return $model;
        }
        else {
            return array('error' => true,'message' => 'Consultant not found');
        }
    }
    
    public function actionConsultentlist(){
                            
        $request            = Yii::$app->request;
        $cat_id             = $request->post('cat_id');
        $sub_cat_id         = $request->post('sub_cat_id');
        if (strpos($sub_cat_id,',') !== false) {
            $sub_cat_id         = explode(',',$sub_cat_id);
        }
        $qualification_id   = $request->post('qualification_id');
        $model              = Consultant::find()->where(['cat_id' => $cat_id])
                             ->andwhere(['qualification_id' => $qualification_id])
                            ->andwhere(new Expression('FIND_IN_SET(:sub_cat_id, sub_cat_id)'))->addParams([':sub_cat_id' => $sub_cat_id])
                            ->andwhere(['status' => 'Active'])
                            ->all();
        if(count($model) > 0) {
            $consultent = [];
            foreach($model as $k=>$conlist){
                $consultent[$k]                         = ArrayHelper::toArray($conlist, [], false);
                $consultent[$k]['rating']               = 0;
                $consultent[$k]['sub_category']         = $conlist->subcatid;
                $consultent[$k]['category_name']        = $conlist->cat->cat_name;
                $consultent[$k]['qualification_name']   = $conlist->qualification->title;
                if(count($conlist->rating) > 0){
                $consultent[$k]['rating']               = $conlist->ratingsum / count($conlist->rating);
                }
            }
            return $consultent;
        }else{
            return array('error' => true,'message' => 'Consultant not found');
        }
        
    }
    
    public function actionCallhistory(){
        $request                = Yii::$app->request;
        $id                     = $request->post('id');
        $call_history           = Callhistory::find()->where(['consultant_id'=>$id,'from_caller'=>'Consultant'])->all();
        if(count($call_history) > 0) {
        $history             = [];
        foreach($call_history as $k=>$con){
         $history[$k]                  = ArrayHelper::toArray($con, [], false);
         $get_call_time = explode(':',$con->call_time);
         /*$hour   = ($get_call_time[0] <> '00')?$get_call_time[0]. " hr ":"";*/
         $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
         $second = ($get_call_time[1] <> '0')?intval($get_call_time[1]). " second":"";
         $call_time = $minute.$second;
         $history[$k]['first_name']          = $con->customer->first_name;
         $history[$k]['last_name']           = $con->customer->last_name;
         $history[$k]['email']               = $con->customer->email;
         $history[$k]['profile_image']       = $con->customer->profile_image;
         $history[$k]['quickbox_id']         = $con->customer->quickbox_id;
         $history[$k]['call_start_time']     = date('h:i A', strtotime($con->call_date));
         $history[$k]['call_date']           = date('Y-m-d', strtotime($con->call_date));
         $history[$k]['call_time']           = $call_time;

        }
         return $history;
        } else {
         return array('error' => true,'message' => 'Customer list not found');
        }
     }
     
     public function actionNotification(){
        $request                = Yii::$app->request;
        $id                     = $request->post('id');
        $call_notification      = Callhistory::find()->where(['consultant_id'=>$id])->all();
        if(count($call_notification) > 0) {
            $notification             = [];
            foreach($call_notification as $k=>$con){
                $notification[$k]              = ArrayHelper::toArray($con, [], false);
                $get_call_time = explode(':',$con->call_time);
                /*$hour   = ($get_call_time[0] <> '00')?$get_call_time[0]. " hr ":"";*/
                $minute = ($get_call_time[0] <> '0')?$get_call_time[0]. " minute ":"";
                $second = ($get_call_time[1] <> '0')?intval($get_call_time[1]). " second":"";
                $call_time = $minute.$second;
               
                $notification[$k]['first_name']          = $con->customer->first_name;
                $notification[$k]['last_name']           = $con->customer->last_name;
                $notification[$k]['email']               = $con->customer->email;
                $notification[$k]['profile_image']       = $con->customer->profile_image;
                $notification[$k]['quickbox_id']         = $con->customer->quickbox_id;
                $notification[$k]['call_start_time']     = date('h:i A', strtotime($con->call_date));
                $notification[$k]['call_date']           = date('Y-m-d', strtotime($con->call_date));
                $notification[$k]['call_time']           = $call_time;
                $notification[$k]['type']     = ($con->from_caller == 'Consultant')?"incoming":"outgoing";
              }
             return $notification;
        } else {
         return array('error' => true,'message' => 'Customer list not found');
        }
     }
}
