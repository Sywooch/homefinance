<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<? if (!$model->immutable) { ?>
			<?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
					'method' => 'post',
				],
			]) ?>
		<? } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_code',
            'name',
			'balanceType.name:text:'.$model->attributeLabels()['balance_type_id'],
        ],
    ]) ?>

</div>
