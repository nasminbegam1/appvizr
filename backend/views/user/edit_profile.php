<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edit Profile';

?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
    <div class="page-header pull-left">
        <div class="page-title">Profile</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
        <i class="fa fa-file-text-o"></i>&nbsp;
        <a href="javascript:void(0);">Edit Profile</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
        </li>
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0);">Update </a>&nbsp;&nbsp;
        </li>
     
    </ol>
    <div class="clearfix"></div>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-yellow">
            <div class="panel-heading">Profile Update</div>
                <div class="panel-body pan">
                    <div class="form-body pal">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => 'Enter your Username']) ?>
                    <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'Enter your Email' ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    </div>
            </div>
        </div>
     
         </div>
</div>