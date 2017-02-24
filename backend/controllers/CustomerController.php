<?php

namespace backend\controllers;

use Yii;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $profile_image  = $model->profile_image;

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
                        
            if( UploadedFile::getInstance($model, 'profile_image') !==null )
            {
                
            if(file_exists(Yii::getAlias('@basePath').'/uploads/customer/' . $profile_image) && $profile_image != ''){
                
                unlink(Yii::getAlias('@basePath').'/uploads/customer/' . $profile_image);
            }
            if(file_exists(Yii::getAlias('@basePath').'/uploads/customer/thumb/' . $profile_image) && $profile_image != ''){
                
                unlink(Yii::getAlias('@basePath').'/uploads/customer/thumb/' . $profile_image);
            }
            
            $model->profile_image   = UploadedFile::getInstance($model, 'profile_image');
            
            $new_img_name           = time() . '_' . str_replace(' ', '_', strtolower($model->profile_image));
             
            $t                      = $model->profile_image->saveAs(Yii::getAlias('@basePath').'/uploads/customer/' . $new_img_name);
            
            $file                   = Yii::getAlias('@basePath').'/uploads/customer/' . $new_img_name;
            
            Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/customer/thumb/' . $new_img_name , ['quality' => 90]);
           
            $model->profile_image   = $new_img_name;
            
            }else{
                
                $model->profile_image   = $profile_image;
            }
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Customer has updated successfully');
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionStatuschange($id){
        $model = $this->findModel($id);
        if($model->status == 'Active'){
            $model->status   = 'Block';
        }else{
            $model->status   = 'Active';
        }
        $model->save();
        Yii::$app->session->setFlash('success', 'Customer status has been changed successfully');
        return $this->redirect(['index']);
    }
    
    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $profile_image = $this->findModel($id)->profile_image;
        
        if(file_exists(Yii::getAlias('@basePath').'/uploads/customer/' . $profile_image) && $profile_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/customer/' . $profile_image);
        }
        if(file_exists(Yii::getAlias('@basePath').'/uploads/customer/thumb/' . $profile_image) && $profile_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/customer/thumb/' . $profile_image);
        }
        
        $this->findModel($id)->delete();
        
        Yii::$app->session->setFlash('success', 'Customer deleted successfully');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
