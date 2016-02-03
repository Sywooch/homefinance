<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Balance Sheets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-sheet-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Balance Sheet', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'period_start',
            'is_month',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
