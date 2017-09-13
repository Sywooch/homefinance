<?
use yii\helpers\Html;
?>
<div class="form-group">
	<?= Html::submitButton(Yii::t('yii', 'No'), ['name'=>'answer', 'value'=>'no', 'class' => 'btn btn-danger']) ?>
	<?= Html::submitButton(Yii::t('yii', 'Yes'), ['name'=>'answer', 'value'=>'yes', 'class' => 'btn btn-success']) ?>
</div>