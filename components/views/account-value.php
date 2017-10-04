<?
use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this Widget */
/* @var $bItemModel BalanceItem */
/* @var $bSheet_id integer*/
/* @var $amountModel BalanceAmount */

$value = Yii::$app->formatter->asCurrency($bItemModel->getAmountByBSheet($bSheet_id));
if (!$value) $value = "not set";

if (isset($amountModel) && !$bItemModel->immutable) {
	Modal::begin([
		'header' => $bItemModel->name.', '.Yii::$app->formatter->asDate($amountModel->balanceSheet->period_start),
		'toggleButton' => ['tag'=>'a', 'label' => $value],
	]);
	echo $this->render('/balance-amount/_form_master', ['model' => $amountModel]);
	Modal::end();
} else {
	echo Html::encode($value);
}
?>