<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Pricerange */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="form-body pal">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'start_price')->dropDownList(array_combine(range(1, 50), range(1, 50))) ?>

    <?= $form->field($model, 'end_price')->dropDownList(array_combine(range(1, 50), range(1, 50))) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'Active' => 'Active', 'Inactive' => 'Inactive', ], ['prompt' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
