<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'order_code',
            'balanceItem.name:text:Balance Item',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
