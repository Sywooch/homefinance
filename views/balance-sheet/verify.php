<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Verify balance';

$this->params['breadcrumbs'][] = ['label' => 'Balance Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->period_start, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-verify-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<style>
		div.balance-verify-index tr[title=over] {
			background-color:#FDD;
		}
	</style>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'rowOptions'=>function ($item) {
			return ['title'=>$item['threshold']];
		},
        'columns' => [

            'order_code',
            'name',
			'AmountOLD:currency',
			'AmountNEW:currency',
			'Decrease:currency',
			'Increase:currency',
			'Result:currency',
        ],
    ]); ?>

</div>
