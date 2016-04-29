<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;

$this->title = 'Balance Amounts for '.$session['balance_sheet_date'];

$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/index'),'label'=>'Balance Sheets');
$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/view', 'id'=>$session['balance_sheet_id']),'label'=>$session['balance_sheet_date']);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-amount-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Balance Amount', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'account.name',
            'amount',
            'balanceSheet.period_start',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
