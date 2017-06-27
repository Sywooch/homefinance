<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TransactionUploadForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Upload Transactions';
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transaction-upload">

    <h1><?= Html::encode($this->title) ?></h1>

	<div class="transaction-upload-form">

		<div class="panel">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

			<?= $form->field($model, 'field_amount')->textInput(['maxlength' => true]) ?>
			
			<div class="row">
				<div class="col-lg-6">
				<?= $form->field($model, 'field_date')->textInput(['maxlength' => true]) ?>
				</div>
				
				<div class="col-lg-6">
				<?= $form->field($model, 'field_date_format')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
			
			<?= $form->field($model, 'field_description')->textInput(['maxlength' => true]) ?>
			
			<?= $form->field($model, 'operation_account_id')->dropDownList($model->getAvailableAccounts()) ?>
			
			<?= $form->field($model, 'inverse_signs')->checkbox() ?>
		</div>
		
		<div class="row panel">
			<div class="col-lg-3">
			<?= $form->field($model, 'csv_separator')->textInput(['maxlength' => true]) ?>
			</div>
			
			<div class="col-lg-3">
			<?= $form->field($model, 'decimal_separator')->textInput(['maxlength' => true]) ?>
			</div>
		</div>
		
		<?= $form->field($model, 'csv_file')->fileInput() ?>

		<div class="form-group">
			<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

	</div>

</div>