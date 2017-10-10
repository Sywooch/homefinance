<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\AccountValue;

/* @var $this yii\web\View */
/* @var $typesList app\models\BalanceItem */
/* @var $bSheets app\models\BalanceSheet */
/* @var $dataProviders[] yii\data\ActiveDataProvider */

?>
	
<?
$showHeader = 1;
$category = 0;
$providerIndex = 0;
$counter = 1;
foreach ($typesList as $type) {
?>
	
	<?= $category == 0
		&& $type->balanceType->isAssets()
		&& ++$category
		? Html::tag('h4', Yii::t('app', 'Assets')) : '' ?>
	<?= $category == 1
		&& $type->balanceType->isLiabilities()
		&& ++$category
		? Html::tag('h4', Yii::t('app', 'Liabilities')) : '' ?>
	<?= $category == 2
		&& $type->balanceType->isOuterAssets()
		&& ++$category
		? Html::tag('h4', Yii::t('app', 'Out of balance assets')) : '' ?>
	
	<h5><?= Html::encode($type->balanceType->name) ?></h5>

	<div class="table-responsive">
	<?= GridView::widget([
		'dataProvider' => $dataProviders[$providerIndex++],
		'showHeader'=> ($showHeader-- == 1),
		'layout'=>'{items}',
		'columns' => [
			[
				'contentOptions' => ['class' => 'col-lg-1'],
				'attribute' => 'order_code',
			],
			'name',
			[
				'label'=>Yii::$app->formatter->asDate($bSheets[0]->period_start),
				'contentOptions' => ['class' => 'col-lg-2', 'bSheet_id'=>$bSheets[0]->id],
				'content'=>function ($model, $key, $index, $column) {
					return AccountValue::widget([
						'bItemModel'=>$model,
						'bSheet_id'=>$column->contentOptions['bSheet_id'],
					]);
				}
			],
			isset($bSheets[1]) ?
			[
				'label'=>Yii::$app->formatter->asDate($bSheets[1]->period_start),
				'contentOptions' => ['class' => 'col-lg-2', 'bSheet_id'=>$bSheets[1]->id],
				'content'=>function ($model, $key, $index, $column) {
					return AccountValue::widget([
						'bItemModel'=>$model,
						'bSheet_id'=>$column->contentOptions['bSheet_id'],
					]);
				}
			] : ['contentOptions' => ['class' => 'col-lg-2']],
			[
				'class' => 'yii\grid\ActionColumn',
				'contentOptions' => ['class' => 'col-lg-1'],
				'visibleButtons' => [
					'view'=>function ($model, $key, $index) {return true;},
					'update'=>function ($model, $key, $index) {return !$model->immutable;},
					'delete'=>function ($model, $key, $index) {return !$model->immutable;},
				],
			],
		],
	]); ?>
	</div>

<? } ?>
<script>
<? $this->beginBlock('setFocus', false); ?>
//$("a[data-toggle=modal]")
//TODO: set auto focus
function  setFocus() {
	$("#balanceamount-amount").focus().select();
}
<? $this->endBlock('setFocus'); ?>
</script>
<? $this->registerJs($this->blocks['setFocus']); ?>