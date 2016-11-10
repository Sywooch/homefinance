<?
use yii\helpers\Html;
?>
<div class="form-group">
	<?= Html::submitButton('No', ['name'=>'answer', 'value'=>'no', 'class' => 'btn btn-danger']) ?>
	<?= Html::submitButton('Yes', ['name'=>'answer', 'value'=>'yes', 'class' => 'btn btn-success']) ?>
</div>