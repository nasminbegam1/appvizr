<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pricerange */

$this->title = 'Update Price range';
$this->params['breadcrumbs'][] = ['label' => 'Priceranges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
    <div class="page-header pull-left">
        <div class="page-title">Price range</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0)">Price range</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
        </li>
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0)">Update</a>&nbsp;&nbsp;
        </li>
     
    </ol>
    <div class="clearfix"></div>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-yellow">
                    <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                    <div class="panel-body pan"> 
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                
                 </div>
            </div>
        </div>
    </div>
</div>