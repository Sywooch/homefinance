<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Balance History');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-sheet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => ['class' => 'col-lg-1'],],

            'period_start:date',

            ['class' => 'yii\grid\ActionColumn',
			'contentOptions' => ['class' => 'col-lg-1'],
			'visibleButtons' => [
					'view'=>function ($model, $key, $index) {return true;},
					'update'=>function ($model, $key, $index) {return false;},
					'delete'=>function ($model, $key, $index) {return true;},
				],
			],
        ],
    ]); ?>

</div>
