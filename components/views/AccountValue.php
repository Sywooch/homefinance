<?
use yii\helpers\Html;
use yii\bootstrap\Modal;

$value = $model->__get($attribute);
if (!$value) $value = "not set";

if ($amount && !$model->immutable) {
	Modal::begin([
		'header' => $model->name.' '.$amount->balanceSheet->period_start,
		'toggleButton' => ['tag'=>'a', 'label' => $value],
	]);
	echo $this->render('/balance-amount/_form_master', ['model' => $amount]);
	Modal::end();
} else {
	echo Html::encode($value);
}
?>