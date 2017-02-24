<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\models\SubCategory;
use app\models\Qualification;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Consultant */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-body pal">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'country_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_image')->fileInput() ?>
    
    <?php if(!$model->isNewRecord){?>
    
    <?= Html::img(Yii::$app->urlManagerFrontend->baseUrl.'/uploads/consultant/thumb/' . $model->profile_image) ?>
    
    <?php } ?>

    <?= $form->field($model, 'cat_id')->dropDownList(ArrayHelper::map(Category::find()->all(), 'id', 'cat_name'),['prompt'=>'Select category','id' => 'catSelect']); ?>

    <?= $form->field($model, 'sub_cat_id')->dropDownList([''=>'Select'],['multiple'=>'multiple','size' => '4','id'=>'selectSubCategory','data-select' => $model->sub_cat_id]);  ?>

    <?= $form->field($model, 'qualification_id')->dropDownList(ArrayHelper::map(Qualification::find()->all(), 'id', 'title'),['prompt'=>'Select Qualification']); ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', 'Block' => 'Block', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
