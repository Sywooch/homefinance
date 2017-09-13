<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Transaction'), ['create'], ['class' => 'btn btn-success']) ?>
		
		<?= Html::a(Yii::t('app', 'Upload Transactions'), ['transaction/upload'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'date',
            'amount',
            'description',
			'category',
			'sub_category',
			[
				'attribute'=>'account_from_id',
				'value'=>'accountFrom.name',
			],
			[
				'attribute'=>'account_to_id',
				'value'=>'accountTo.name',
			],
			[
				'attribute'=>'for_review',
				'format'=>'html',
				'value'=>function ($item) {
					if ($item->for_review) return Html::a(Html::tag('span', Yii::t('yii', 'Yes'), ['class'=>'glyphicon glyphicon-search']), ['review', 'id'=>$item->id]);
					else return Yii::t('yii', 'No');
				},
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
