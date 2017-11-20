<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Knowledge Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Knowledge Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'name',
            'full_text:ntext',
			[
				'attribute'=>'image_url',
				'format'=>'html',
				'value'=>function($model) {
					return Html::a($model->image_url, Yii::getAlias('@web').'/'.$model->image_url);
				}
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
