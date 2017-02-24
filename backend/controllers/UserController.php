<?php

namespace backend\controllers;
use Yii;
use common\models\User;
use app\models\SubCategory;
use app\models\Category;
use app\models\Qualification;
use app\models\Country;

class UserController extends BaseController
{
        /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['editprofile','changepassword'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ], 
        ];
    }

    public function actionDashboard()
    {
        $model              = array();
        
        
        return $this->render('dashboard', [
                'model'             => $model,
                'subcat'            => SubCategory::find()->count(),
                'category'          => Category::find()->count(),
                'qualification'     => Qualification::find()->count(),
                'country'           => Country::find()->count()
                
            ]);
    }
    
    public function actionEditprofile()
    {
        
        $id         = Yii::$app->user->identity->id;
        $model      = User::findOne($id);
        
        // For validation
        $model->scenario = 'changeprofile';
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->username    = $model->username;
            $model->email       = $model->email;
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Profile Details Changed successfully');
            return $this->redirect(['user/editprofile']);
        } else {
            return $this->render('edit_profile', [
                'model' => $model,
            ]);
        }
    }
    public function actionChangepassword(){
        $id         = Yii::$app->user->identity->id;
        $model      = User::findOne($id);
        
        $model->scenario = 'changepassword';
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->password_hash       = Yii::$app->security->generatePasswordHash($model->password);
            $model->save();
            \Yii::$app->getSession()->setFlash('success', 'Password Changed successfully');
            
            return $this->redirect(['user/changepassword']);
        } else {
            return $this->render('changePassword', [
                'model' => $model,
            ]);
        }
    }
}
