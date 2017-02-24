<?php

namespace backend\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use app\models\SubCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionTest()
    {
        
       print_r(Yii::$app->request->post());
       exit;
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if( UploadedFile::getInstance($model, 'cat_image') !==null )
            {
            
            $model->cat_image   = UploadedFile::getInstance($model, 'cat_image');
            
            $new_img_name       = time() . '_' . str_replace(' ', '_', strtolower($model->cat_image));
             
            $t                  = $model->cat_image->saveAs(Yii::getAlias('@basePath').'/uploads/category/' . $new_img_name);
            
            $file               = Yii::getAlias('@basePath').'/uploads/category/' . $new_img_name;
            Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $new_img_name , ['quality' => 90]);
            //Image::thumbnail($file, 200, 200)->save(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $new_img_name, ['quality' => 80]);
            $model->cat_image   = $new_img_name;
            
            $model->created_at  = date('Y-m-d H:i:s');
            }else{
                
                return $this->render('create', [
                    'model' => $model,
                    'error' => 'File Can\'t be blank'
                ]);
            }
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Category has added successfully');

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model      = $this->findModel($id);
        
        $cat_image  = $model->cat_image;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if( UploadedFile::getInstance($model, 'cat_image') !==null )
            {
                if(file_exists(Yii::getAlias('@basePath').'/uploads/category/' . $cat_image) && $cat_image != ''){
                    
                    unlink(Yii::getAlias('@basePath').'/uploads/category/' . $cat_image);
                }
                if(file_exists(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $cat_image) && $cat_image != ''){
                    
                    unlink(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $cat_image);
                }
                $model->cat_image   = UploadedFile::getInstance($model, 'cat_image');
                
                $new_img_name       = time() . '_' . str_replace(' ', '_', strtolower($model->cat_image)); 
                
                $t                  = $model->cat_image->saveAs(Yii::getAlias('@basePath').'/uploads/category/' . $new_img_name);
                
                $file               = Yii::getAlias('@basePath').'/uploads/category/' . $new_img_name;

                //Image::thumbnail($file, 200, 200)->save(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $new_img_name, ['quality' => 80]);
                Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $new_img_name , ['quality' => 90]);
                $model->cat_image   = $new_img_name;
            
            }else{
                $model->cat_image   = $cat_image;
            }
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Category has updated successfully');
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $cat_image = $this->findModel($id)->cat_image;
        if(file_exists(Yii::getAlias('@basePath').'/uploads/category/' . $cat_image) && $cat_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/category/' . $cat_image);
        }
        if(file_exists(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $cat_image) && $cat_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/category/thumb/' . $cat_image);
        }
        
        $this->findModel($id)->delete();
        
        Yii::$app->session->setFlash('success', 'Category deleted successfully');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}