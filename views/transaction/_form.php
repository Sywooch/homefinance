<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transaction-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date')->textInput() ?>
	
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
	
    <?= $form->field($model, 'sub_category')->textInput(['maxlength' => true]) ?>

    <?
	$src = $model->getAccountDict();
	echo $form->field($model, 'account_from_id')->dropdownList($src, ['prompt'=>Yii::t('app', '- add -')]);
	echo $form->field($model, 'account_to_id')->dropdownList($src, ['prompt'=>Yii::t('app', '- remove -')]);
	?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('yii', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	<? $this->registerJsFile('basic/web/js/init.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

</div>
