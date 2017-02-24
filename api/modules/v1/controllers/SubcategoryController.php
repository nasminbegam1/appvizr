<?php

namespace api\modules\v1\controllers;
use yii\rest\ActiveController;

use api\modules\v1\models\SubCategory;
use yii\helpers\ArrayHelper;
use yii;


class SubcategoryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\SubCategory';
    
    public function behaviors()
    {
        return [
            [
                'class' => \yii\filters\ContentNegotiator::className(),
                'only' => ['index', 'view', 'update','getlist'],
                'formats' => [
                    'application/json' => \yii\web\Response::FORMAT_JSON,
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }
    
    public function actionGetlist()
    {
        $post_data = Yii::$app->request->post();
        $category_id   = $post_data['category_id'];
        $sub_category_list = SubCategory::find()->where(['cat_id'=>$category_id])->all();
        if(count($sub_category_list) > 0) {
            return $sub_category_list;
        } else {
           return array('error' => true,'message'=>'Subcategory list not found');
        }
        
     }

}
