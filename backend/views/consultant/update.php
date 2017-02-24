<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */

$this->title = 'Update Consultant: ' . $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Consultants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
    <div class="page-header pull-left">
        <div class="page-title">Consultant</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0)">Consultant</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
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

