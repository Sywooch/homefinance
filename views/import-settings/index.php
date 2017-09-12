<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-settings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Import Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
			'code',
            'name',
			[
				'attribute'=>'user_id',
				'value'=>'user.username'
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
