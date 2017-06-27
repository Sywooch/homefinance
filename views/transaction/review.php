<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = 'Review Transaction: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Transactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Review';
?>
<div class="transaction-review">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date',
			'amount',
			'description',
            'accountFrom.name:text:From Account',
            'accountTo.name:text:To Account',
        ],
    ]) ?>
	
	<h2>Setup category</h2>
    
	<div class="transaction-form">

		<?php $form = ActiveForm::begin(); ?>
	
		<?= $form->field($model, 'description_trigger')->textInput(['maxlength' => true]) ?>
	
		<?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'sub_category')->textInput(['maxlength' => true]) ?>
		
		<div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name'=>'action', 'value'=>'Save']) ?>
			
			<?= Html::submitButton('Save and Apply', ['class' => 'btn btn-success', 'name'=>'action', 'value'=>'Save and Apply']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	
	</div>

</div>
