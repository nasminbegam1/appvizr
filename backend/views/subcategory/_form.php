<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\SubCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-body pal">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'cat_name'),['prompt'=>'Select category']);?>

    <?= $form->field($model, 'subcat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subcat_image')->fileInput() ?>
    
    <?php if(!$model->isNewRecord){?>
    
    <?= Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/subcategory/thumb/' . $model->subcat_image) ?>
    
    <?php } ?>

    <?= $form->field($model, 'subcat_status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        &nbsp;
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
