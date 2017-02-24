<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Category */

$this->title = 'Create Category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
    <div class="page-header pull-left">
        <div class="page-title"><?= Html::encode($this->title) ?></div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0)"><?= Html::encode($this->title) ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
        </li>
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0)">Create</a>&nbsp;&nbsp;
        </li>
     
    </ol>
    <div class="clearfix"></div>
</div>
<div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
		    <div class="panel panel-yellow">
                            <div class="panel-heading"><?= Html::encode($this->title) ?></div>
                            <?php if(isset($error) && $error != ''){ ?>
                                    <div class="alert alert-danger"><?= $error; ?></div>
                            <?php } ?>
                            <div class="panel-body pan">
                                
                                <?= $this->render('_form', [
                                    'model' => $model,
                                ]) ?>
                                
                            </div>
                    </div>
                </div>
            </div>
</div>

