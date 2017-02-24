<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Category;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SubCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Categories';
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
                <div class="actions">
                    <?= Html::a('Create Sub Category', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </div>
            </div>
            <div class="portlet-body">
                <div id="flip-scroll">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'id',
                            //'cat_id',
                            [
                                    'label'=>'Image',
                                    'attribute'=>'subcat_image',
                                    'format' => 'html',
                                    'value' => function($data) {
                                            return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/subcategory/thumb/' . $data->subcat_image);
                                    },    
                                    'filter'=>false,   
                            ],
                            [
                                'attribute'=>'cat_id',
                                'value' => function ($data) {
                                    return $data->cat->cat_name; 
                                },
                                'filter'=>ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'cat_name')  
                                       
                            ],
                            'subcat_name',
                            [
                                    'attribute'=>'subcat_status',
                                    'label'=>'Status',
                                    'value' => function ($data) {
                                        return $data->subcat_status; 
                                    },       
                                    'filter'=>array("Active"=>"Active","Inactive"=>"Inactive")
                            ],
                            //'subcat_status',
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
