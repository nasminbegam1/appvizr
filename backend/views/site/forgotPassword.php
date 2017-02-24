<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

            <?php $form = ActiveForm::begin(['options' => ['class' => 'form-validate' ]]); ?>
                <div class="form-group">
                    <div class="input-icon right"><i class="fa fa-user"></i>
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder' => 'Enter your Email'])->label(false) ?>
                    </div>
                </div>
                <div class="form-group pull-right">
                    <?= Html::submitButton('Get Password&nbsp;'.Html::tag('i', '', ['class' => 'fa fa-chevron-circle-right']) , ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                </div>
                <div class="clearfix"></div>
                <div class="text-center">
                    <p><small>Never mind, <a href="<?= Url::toRoute('/site/login')?>" class='btn-forgot-pwd'>send me back to the sign-in screen</a></small></p>
                </div>
            <hr>
            <?php ActiveForm::end(); ?>
</div>
