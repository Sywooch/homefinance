<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\AccountValue;
use app\models\BalanceSheet;

/* @var $this yii\web\View */
/* @var $typesList app\models\BalanceItem */
/* @var $dataProviders[] yii\data\ActiveDataProvider */
$bSheets = BalanceSheet::LastTwo();

$this->title = Yii::t('app', 'Current Balance');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <p>
        <?= Html::a(Yii::t('app', 'New Month'), ['balance-sheet/create-next'], ['class' => 'btn btn-success']) ?>
		
		<?= Html::a(Yii::t('app', 'Verify Change'), ['balance-sheet/verify-change', 'id'=>$bSheets[0]->id], ['class' => 'btn btn-default']) ?>
		
		<?= Html::a(Yii::t('app', 'Upload Transactions'), ['transaction/upload'], ['class' => 'btn btn-default']) ?>
		
		<?= Html::a(Yii::t('app', 'New Balance Item'), ['create'], ['class' => 'btn btn-default']) ?>
    </p>
	
	<?
	$category = 0;
	$providerIndex = 0;
	foreach ($typesList as $type) {
	?>
		
		<?= $category == 0
			&& $type->balanceType->isAssets()
			&& ++$category
			? Html::tag('h2', Yii::t('app', 'Assets')) : '' ?>
		<?= $category == 1
			&& $type->balanceType->isLiabilities()
			&& ++$category
			? Html::tag('h2', Yii::t('app', 'Liabilities')) : '' ?>
		<?= $category == 2
			&& $type->balanceType->isOuterAssets()
			&& ++$category
			? Html::tag('h2', Yii::t('app', 'Out of balance assets')) : '' ?>
		
		<h3><?= Html::encode($type->balanceType->name) ?></h3>

		<div class="table-responsive">
		<?= GridView::widget([
			'dataProvider' => $dataProviders[$providerIndex++],
			'columns' => [
				[
					'headerOptions' => ['class' => 'col-lg-1'],
					'attribute' => 'order_code',
				],
				'name',
				[
					'label'=>$bSheets[0]->period_start,
					'headerOptions' => ['class' => 'col-lg-2'],
					'content'=>function ($model, $key, $index, $column) {
						return AccountValue::widget([
							'model'=>$model,
							'attribute'=>'currentAmount',
						]);
					}
				],
				[
					'label'=>$bSheets[1]->period_start,
					'headerOptions' => ['class' => 'col-lg-2'],
					'content'=>function ($model, $key, $index, $column) {
						return AccountValue::widget([
							'model'=>$model,
							'attribute'=>'previousAmount',
						]);
					}
				],
				[
					'class' => 'yii\grid\ActionColumn',
					'headerOptions' => [
						'class' => 'action-column col-lg-1',
					],
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
</div>
