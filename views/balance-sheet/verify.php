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
<div class="balance-item-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'order_code',
            'name',
			'AmountOLD:decimal',
			'AmountNEW:decimal',
			'Decrease:decimal',
			'Increase:decimal',
			'Balance:decimal',
        ],
    ]); ?>

</div>
