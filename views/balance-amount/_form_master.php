<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceAmount */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balance-amount-form">

    <?php $form = ActiveForm::begin([
		'action' => array('balance-amount/update-amount-ajax', 'id'=>$model->id),
		'options' => array(
			'id' => 'updateAmount'.$model->id
		)
	]); ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
