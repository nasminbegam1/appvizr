<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
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
                    <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
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
                            //'token_id',
                            [
                                'label'=>'Image',
                                'attribute'=>'profile_image',
                                'format' => 'html',
                                'value' => function($data) {
                                        return Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/customer/thumb/' . $data->profile_image);
                                },    
                                'filter'=>false,   
                            ],
                            [
                                'attribute'=>'first_name',
                                'label'=>'Name',
                                'value' => function ($data) {
                                    return $data->first_name.' '.$data->last_name; 
                                }
                                       
                            ],
                            //'last_name',
                            'email:email',
                            [
                                'attribute'=>'phone',
                                'label'=>'Phone',
                                'value' => function ($data) {
                                    return $data->country_code.$data->phone; 
                                }
                                       
                            ],   
                            // 'password',
                            // 'profile_image',
                            [
                                'attribute'=>'status',
                                'format' => 'html',
                                'value' => function ($data) {
                                    return ($data->status != 'Inactive')?($data->status == 'Active')?"<a href='".Yii::$app->urlManager->baseUrl.'/customer/statuschange?id='.$data->id."' class='btn btn-success confirmMsg'>".$data->status.'</a>':"<a href='".Yii::$app->urlManager->baseUrl.'/customer/statuschange?id='.$data->id."' class='btn btn-danger confirmMsg'>".$data->status.'</a>':"<a href='javascript:void(0)' class='btn btn-warning'>".$data->status.'</a>'; 
                                },
                                'filter'=>['Active' => 'Active','Inactive' => 'Inactive', 'Block' => 'Block']       
                            ],
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
