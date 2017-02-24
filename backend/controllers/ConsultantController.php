<?php

namespace backend\controllers;

use Yii;
use app\models\Consultant;
use app\models\ConsultantSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\SubCategory;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * ConsultantController implements the CRUD actions for Consultant model.
 */
class ConsultantController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'only' => ['index','view','update','statuschange'],
                'rules' => [
                    // allow authenticated users
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    // everything else is denied
                ],
            ], 
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Consultant models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConsultantSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Consultant model.
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
     * Creates a new Consultant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Consultant();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Consultant model.
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
            
            if(file_exists(Yii::getAlias('@basePath').'/uploads/consultant/' . $profile_image) && $profile_image != ''){
                
                unlink(Yii::getAlias('@basePath').'/uploads/consultant/' . $profile_image);
            }
            if(file_exists(Yii::getAlias('@basePath').'/uploads/consultant/thumb/' . $profile_image) && $profile_image != ''){
                
                unlink(Yii::getAlias('@basePath').'/uploads/consultant/thumb/' . $profile_image);
            }
            $model->profile_image   = UploadedFile::getInstance($model, 'profile_image');
            
            $new_img_name           = time() . '_' . str_replace(' ', '_', strtolower($model->profile_image));
             
            $t                      = $model->profile_image->saveAs(Yii::getAlias('@basePath').'/uploads/consultant/' . $new_img_name);
            
            $file                   = Yii::getAlias('@basePath').'/uploads/consultant/' . $new_img_name;
            
            Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/consultant/thumb/' . $new_img_name , ['quality' => 90]);
           
            $model->profile_image   = $new_img_name;
            
            }else{
                $model->profile_image   = $profile_image;
            }
            $model->sub_cat_id  = implode(',',$model->sub_cat_id);
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Consultant has updated successfully');
            
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
        Yii::$app->session->setFlash('success', 'Consultant status has been changed successfully');
        return $this->redirect(['index']);
    }
    /**
     * Deletes an existing Consultant model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $profile_image = $this->findModel($id)->profile_image;
        if(file_exists(Yii::getAlias('@basePath').'/uploads/consultant/' . $profile_image) && $profile_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/consultant/' . $profile_image);
        }
        if(file_exists(Yii::getAlias('@basePath').'/uploads/consultant/thumb/' . $profile_image) && $profile_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/consultant/thumb/' . $profile_image);
        }
        
        $this->findModel($id)->delete();
        
        Yii::$app->session->setFlash('success', 'Consultant deleted successfully');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Consultant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Consultant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Consultant::findOne($id)) !== null) {
            $model->sub_cat_name = SubCategory::find()->select(['GROUP_CONCAT(DISTINCT(subcat_name) ORDER BY subcat_name ASC) as subcat_name'])->where(['id' => explode(',',$model->sub_cat_id)])->one();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionGet_subcategory(){
        $postData = Yii::$app->request->post();
        $model  = SubCategory::find()->where(['cat_id' => $postData['catId']])->asArray()->all();
        echo json_encode($model);
    }
}
