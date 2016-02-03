<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Balance Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-view">

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
            'order_code',
            'name',
			'balanceType.name:text:Type'
        ],
    ]) ?>

</div>
