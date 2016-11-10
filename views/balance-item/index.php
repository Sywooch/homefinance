<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\AccountValue;
use app\models\BalanceSheet;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$bSheets = BalanceSheet::LastTwo();

$this->title = 'Balance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <p>
        <?= Html::a('New Month', ['balance-sheet/create-next'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'order_code',
            'balanceType.name:text:Type',
            'name',
			[
				'label'=>'Current Amount by '.$bSheets[0]->period_start,
				'content'=>function ($model, $key, $index, $column) {
					return AccountValue::widget([
						'model'=>$model,
						'attribute'=>'currentAmount',
					]);
				}
			],
			[
				'label'=>'Previous Amount by '.$bSheets[1]->period_start,
				'content'=>function ($model, $key, $index, $column) {
					return AccountValue::widget([
						'model'=>$model,
						'attribute'=>'previousAmount',
					]);
				}
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <p>
        <?= Html::a('New Balance Item', ['create'], ['class' => 'btn btn-default']) ?>
    </p>
	<p>
		Сводные данные:
		<ul>
		<li>Всего Активы: <?= $bSheets[0]->getTotal(1) ?></li>
		<li>Всего Пассивы: <?= $bSheets[0]->getTotal(0) ?></li>
		<li>Поправка на текущий остаток: <?= $bSheets[0]->getTotal(1) - $bSheets[0]->getTotal(0) ?></li>
		</ul>
	</p>
</div>
