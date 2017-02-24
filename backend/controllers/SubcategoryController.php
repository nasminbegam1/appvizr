<?php

namespace backend\controllers;

use Yii;
use app\models\SubCategory;
use app\models\SubCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * SubcategoryController implements the CRUD actions for SubCategory model.
 */
class SubcategoryController extends BaseController
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
     * Lists all SubCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubCategory model.
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
     * Creates a new SubCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SubCategory();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            if( UploadedFile::getInstance($model, 'subcat_image') !==null )
            {
            
            $model->subcat_image    = UploadedFile::getInstance($model, 'subcat_image');
            
            $new_img_name           = time() . '_' . str_replace(' ', '_', strtolower($model->subcat_image));
             
            $t                      = $model->subcat_image->saveAs(Yii::getAlias('@basePath').'/uploads/subcategory/' . $new_img_name);
            
            $file                   = Yii::getAlias('@basePath').'/uploads/subcategory/' . $new_img_name;
            
            Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $new_img_name , ['quality' => 90]);
            
            $model->subcat_image   = $new_img_name;
            
            $model->created_at  = date('Y-m-d H:i:s');
            }else{
                
                return $this->render('create', [
                    'model' => $model,
                    'error' => 'File Can\'t be blank'
                ]);
            }
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Sub-category has added successfully');

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SubCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $subcat_image  = $model->subcat_image;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            if( UploadedFile::getInstance($model, 'subcat_image') !==null )
            {
                if(file_exists(Yii::getAlias('@basePath').'/uploads/subcategory/' . $subcat_image) && $subcat_image != ''){
                    
                    unlink(Yii::getAlias('@basePath').'/uploads/subcategory/' . $subcat_image);
                }
                if(file_exists(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $subcat_image) && $subcat_image != ''){
                    
                    unlink(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $subcat_image);
                }
                $model->subcat_image   = UploadedFile::getInstance($model, 'subcat_image');
                
                $new_img_name       = time() . '_' . str_replace(' ', '_', strtolower($model->subcat_image)); 
                
                $t                  = $model->subcat_image->saveAs(Yii::getAlias('@basePath').'/uploads/subcategory/' . $new_img_name);
                
                $file               = Yii::getAlias('@basePath').'/uploads/subcategory/' . $new_img_name;

                Image::getImagine()->open($file)->thumbnail(new Box(150, 150))->save(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $new_img_name , ['quality' => 90]);
                $model->subcat_image   = $new_img_name;
            
            }else{
                $model->subcat_image   = $subcat_image;
            }
            
            $model->save();
            
            Yii::$app->session->setFlash('success', 'Sub category has updated successfully');
            
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SubCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $subcat_image = $this->findModel($id)->subcat_image;
        if(file_exists(Yii::getAlias('@basePath').'/uploads/subcategory/' . $subcat_image) && $subcat_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/subcategory/' . $subcat_image);
        }
        if(file_exists(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $subcat_image) && $subcat_image != ''){
            
            unlink(Yii::getAlias('@basePath').'/uploads/subcategory/thumb/' . $subcat_image);
        }
        
        $this->findModel($id)->delete();
        
        Yii::$app->session->setFlash('success', 'Sub-category deleted successfully');

        return $this->redirect(['index']);
    }

    /**
     * Finds the SubCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SubCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
