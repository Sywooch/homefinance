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

    <?
	$src = \app\models\BalanceItem::find()->select('name, id')->indexBy('id')->column();
	echo $form->field($model, 'from_item_id')->dropdownList($src, ['prompt'=>'- add -']);
	echo $form->field($model, 'to_item_id')->dropdownList($src, ['prompt'=>'- remove -']);
	?>

    <?= $form->field($model, 'date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	<? $this->registerJsFile('basic/web/js/init.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>

</div>
