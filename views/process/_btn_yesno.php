<?
use yii\helpers\Html;
?>
<div class="form-group">
	<?= Html::submitButton('Нет', ['name'=>'answer', 'value'=>'no', 'class' => 'btn btn-danger']) ?>
	<?= Html::submitButton('Да', ['name'=>'answer', 'value'=>'yes', 'class' => 'btn btn-success']) ?>
</div>