<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceSheet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balance-sheet-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'period_start')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	<? $this->registerJsFile('basic/web/js/init.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

</div>
