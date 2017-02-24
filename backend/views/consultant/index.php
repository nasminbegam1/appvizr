<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Category;
use app\models\SubCategory;
use app\models\Qualification;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsultantSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Consultants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
        <div class="page-header pull-left">
                        <div class="page-title"><?= Html::encode($this->title) ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li>
                <i class="fa fa-building-o"></i>&nbsp;
                <a href="javascript:void(0);"><?= Html::encode($this->title) ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
            </li>
            <li>
                <i class="fa fa-list"></i>&nbsp;
                <a href="javascript:void(0);">List</a>&nbsp;&nbsp;
            </li>
        </ol>
        <div class="clearfix"></div>
</div>
<div class="page-content">
    <div class="row">
    <div class="col-lg-12">
        <div class="portlet box portlet-orange">
            <div class="portlet-header">
                <div class="caption"><?= Html::encode($this->title) ?> List</div>
                <!--<div class="actions">
                <?= Html::a('Create Consultant', ['create'], ['class' => 'btn btn-success']) ?>
                </div>-->
            </div>
            <div class="portlet-body">
                <div id="flip-scroll">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'tableOptions'=>['class'=>'table table-striped table-bordered icon-view'],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'id',
                            //[
                            //    'label'=>'Image',
                            //    'attribute'=>'profile_image',
                            //    'format' => 'html',
                            //    'value' => function($data) {
                            //            return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/consultant/thumb/' . $data->profile_image);
                            //    },    
                            //    'filter'=>false,   
                            //],
                            [
                                'attribute'=>'first_name',
                                'label'=>'Name',
                                'value' => function ($data) {
                                    return $data->first_name.' '.$data->last_name; 
                                }
                                       
                            ],
                            //'token_id',
                            //'first_name',
                            //'last_name',
                            'email:email',
                            // 'password',
                             [
                                'attribute'=>'phone',
                                'label'=>'Phone',
                                'value' => function ($data) {
                                    return $data->country_code.$data->phone; 
                                }
                                       
                            ],       
                             [
                                'attribute'=>'cat_id',
                                'value' => function ($data) {
                                    return $data->cat->cat_name; 
                                },
                                'filter'=>ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'cat_name')  
                                       
                            ],
                            [
                                'attribute'=>'sub_cat_id',
                                'format' => 'html',
                                'value' => function ($model) {
                                    return str_replace(",","<br>", $model->Sub_cat_id); 
                                },
                                'filter'=>ArrayHelper::map(SubCategory::find()->asArray()->all(), 'id', 'subcat_name')  
                                       
                            ],
                            [
                                'attribute'=>'qualification_id',
                                'value' => function ($data) {
                                    return $data->qualification->title; 
                                },
                                'filter'=>ArrayHelper::map(Qualification::find()->asArray()->all(), 'id', 'title')  
                                       
                            ],
                            [
                                'attribute'=>'status',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return ($data->status != 'Inactive')?($data->status == 'Active')?"<a href='".Yii::$app->urlManager->baseUrl.'/consultant/statuschange?id='.$data->id."' class='btn btn-success confirmMsg'>".$data->status.'</a>':"<a href='".Yii::$app->urlManager->baseUrl.'/consultant/statuschange?id='.$data->id."' class='btn btn-danger confirmMsg'>".$data->status.'</a>':"<a href='javascript:void(0)' class='btn btn-warning'>".$data->status.'</a>'; 
                                },
                                'filter'=>['Active' => 'Active','Inactive' => 'Inactive', 'Block' => 'Block']       
                            ],
                            // 'description:ntext',
                            //'status',
                            // 'registration_type',
                            // 'created_at',
                            // 'updated_at',
                
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
