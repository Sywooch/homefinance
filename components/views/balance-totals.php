<?
use yii\helpers\Html;
use yii\bootstrap\Modal;

/* @var $this Widget */
/* @var $bSheet BalanceSheet */
/* @var $typesList[] BalanceItemExt */
?>

<table class="table table-striped table-bordered"><tr>
	<th><?= Yii::t('app', 'Assets') ?></th>
	<td><?= Yii::$app->formatter->asCurrency($bSheet->getTotal(1)) ?></td>
</tr>
<? foreach ($typesList as $itemType) { ?>
<tr>
	<th><?= $itemType->balanceType->name ?></th>
	<td><?= Yii::$app->formatter->asCurrency($itemType->getAmountByBSheet($bSheet->id)) ?></td>
</tr>
<? } ?>
<tr>
	<th><?= Yii::t('app', 'Out of balance assets') ?></th>
	<td><?= Yii::$app->formatter->asCurrency($bSheet->getTotal(3)) ?></td>
</tr></table>
