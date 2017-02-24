<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'form-validate' ]]); ?>
            
            <div class="form-group">
                <div class="input-icon right"><i class="fa fa-user"></i>
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder' => 'Enter your username'])->label(false) ?>
                </div>
            </div>
            <div class="form-group">
                <div class="input-icon right"><i class="fa fa-key"></i>
                    <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Enter your Password'])->label(false) ?>
                </div>
            </div>
           <div class="form-group pull-left">
                <div class="checkbox-list"><label><?= $form->field($model, 'rememberMe')->checkbox() ?>
                </label></div>
           </div>
            <div class="form-group pull-right">
                <?= Html::submitButton('Login &nbsp;'.Html::tag('i', '', ['class' => 'fa fa-chevron-circle-right']), ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
            </div>
            <div class="clearfix"></div>
            <div class="forget-password"><h4>Forgotten your Password?</h4>

            <p>no worries, click <a href='<?= Url::toRoute('/site/forgotpassword')?>' class='btn-forgot-pwd'>here</a> to reset your password.</p></div>
            <hr>
        <?php ActiveForm::end(); ?>
