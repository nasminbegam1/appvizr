<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-body pal">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'cat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cat_image')->fileInput() ?>
    
    <?php if(!$model->isNewRecord){?>
    
    <?= Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/category/thumb/' . $model->cat_image) ?>
    
    <?php } ?>

    <?= $form->field($model, 'cat_status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        &nbsp;
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
