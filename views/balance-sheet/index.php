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

    <p>
        <?= Html::a(Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Balance Sheet'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'period_start:date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
