<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ImportSettings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Import Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-settings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
			'code',
			[
				'attribute'=>'user_id',
				'value'=>$model->user->username
			],
        ],
    ]) ?>
	
	<div class="panel panel-default">
		<p class="panel-heading"><?= $model->attributeLabels()['payload'] ?></p>
		<p class="panel-body" style="word-wrap: break-word;"><?= Html::encode($model->payload) ?></p>
	</div>

</div>
