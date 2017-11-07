<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionUploadForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = Yii::t('app', 'Upload Transactions');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Transactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Upload');
?>
<div class="transaction-upload">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="transaction-upload-form">

		<div class="">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
			
			<?= $form->field($model, 'csv_file')->fileInput() ?>
						
			<h2><?= Yii::t('app', 'Specify CSV format') ?></h2>

			<div class="row">
				<div class="col-lg-6">
				<?= $form->field($model, 'field_amount')->textInput(['maxlength' => true])->
					hint($model->getHints()['field_amount']) ?>
				</div>
				
				<div class="col-lg-6">
				<?= $form->field($model, 'field_description')->textInput(['maxlength' => true])->
					hint($model->getHints()['field_description']) ?>
				</div>
			</div>
			
			<div class="row">
				<div class="col-lg-6">
				<?= $form->field($model, 'field_date')->textInput(['maxlength' => true])->
					hint($model->getHints()['field_date']) ?>
				</div>
				
				<div class="col-lg-6">
				<?= $form->field($model, 'field_date_format')->textInput(['maxlength' => true])->
					hint($model->getHints()['field_date_format']) ?>
				</div>
			</div>
			
			<?= $form->field($model, 'inverse_signs')->checkbox()->
				hint($model->getHints()['inverse_signs']) ?>
		</div>
		
		<div class="row">
			<div class="col-lg-3">
			<?= $form->field($model, 'csv_separator')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div class="col-lg-3">
			<?= $form->field($model, 'decimal_separator')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		
		<?= $form->field($model, 'operation_account_id')->dropDownList($model->getAvailableAccounts())->
			hint($model->getHints()['operation_account_id']) ?>

		<div class="form-group">
			<?= Html::submitButton(Yii::t('app', 'Upload'), ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>