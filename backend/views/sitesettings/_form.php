<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sitesettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-body pal">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sitesettings_lebel')->textInput(['maxlength' => true,'readonly'=>'readonly']) ?>

    <?php if($model->sitesettings_type == 'TEXTAREA'){ ?>
    
    <?= $form->field($model, 'sitesettings_value')->textarea(['rows' => 6]) ?>
    
    <?php }else{ ?>

    <?= $form->field($model, 'sitesettings_value')->textInput(['maxlength' => true]) ?>
    
    <?php } ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
