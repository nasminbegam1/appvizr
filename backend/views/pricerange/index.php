<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PricerangeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Price Ranges';
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
                    <?= Html::a('Create Price Range', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                </div>-->
            </div>
            <div class="portlet-body">
                <div id="flip-scroll">
                <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        //'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                
                            //'id',
                            [
                                'attribute'=>'start_price',
                                'contentOptions'=>['style'=>'text-align:left'],
                                'value' => function ($data) {
                                    return $data->start_price; 
                                },
                                'filter'=>false    
                            ],
                            [
                                'attribute'=>'end_price',
                                'contentOptions'=>['style'=>'text-align:left'],
                                'value' => function ($data) {
                                    return $data->end_price; 
                                },
                                'filter'=>false 
                                       
                            ],
                            //'status',
                            //'created_at',
                            // 'updated_at',
                
                            ['class' => 'yii\grid\ActionColumn',
                             'template' => '{update}'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

