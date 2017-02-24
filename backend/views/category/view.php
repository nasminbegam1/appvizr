<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = $model->cat_name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
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
                                        <a href="javascript:void(0);">View</a>&nbsp;&nbsp;
                        </li>
        </ol>
        <div class="clearfix"></div>
</div>
<div class="page-content">
    <div class="row">
    <div class="col-lg-12">
        <div class="portlet box portlet-orange">
            <div class="portlet-header">
                        <h5><?= Html::encode($this->title) ?></h5>
            </div>

            <div class="portlet-body">
                <div id="flip-scroll">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'cat_name',
                            array('attribute'=>'Image',
                                'value'=>Yii::$app->urlManagerFrontend->baseUrl.'/uploads/category/thumb/'.$model->cat_image,
                                'format' => ['image'],
                            ),
                            'cat_status',
                            'created_at',
                            //'updated_at',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
