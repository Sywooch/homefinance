<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Transactions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Transaction', ['create'], ['class' => 'btn btn-success']) ?>
		
		<?= Html::a('Upload Transactions', ['transaction/upload'], ['class' => 'btn btn-default']) ?>
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
            'accountFrom.name:text:From Account',
            'accountTo.name:text:To Account',
			'for_review:boolean',
			[
				'label'=>'For Review',
				'format'=>'html',
				'value'=>function ($item) {
					if ($item->for_review) return Html::a(Html::tag('span', 'Yes', ['class'=>'glyphicon glyphicon-search']), ['review', 'id'=>$item->id]);
					else return 'No';
				},
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
