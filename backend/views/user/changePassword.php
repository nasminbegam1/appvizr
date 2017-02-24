<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change Password';

?>
<div class="page-title-breadcrumb" id="title-breadcrumb-option-demo">
    <div class="page-header pull-left">
        <div class="page-title">Change Password</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li>
        <i class="fa fa-file-text-o"></i>&nbsp;
        <a href="javascript:void(0);">Change </a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;
        </li>
        <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="javascript:void(0);">Password </a>&nbsp;&nbsp;
        </li>
     
    </ol>
    <div class="clearfix"></div>
</div>
<div class="page-content">
    <div class="row">
        <div class="col-lg-12">
        <div class="panel panel-yellow">
            <div class="panel-heading">Change Password</div>
                <div class="panel-body pan">
                    <div class="form-body pal">
                    <?php $form = ActiveForm::begin(); ?>
                    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true,'placeholder' => 'Enter your password']) ?>
                    <?= $form->field($model, 'confirmpassword')->passwordInput(['autofocus' => true,'placeholder' => 'Enter confirm password' ]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    </div>
            </div>
        </div>
     
         </div>
</div>