<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceAmount */

$this->title = $model->id;
$session = Yii::$app->session;
$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/index'),'label'=>'Balance Sheets');
$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/view', 'id'=>$session['balance_sheet_id']),'label'=>$session['balance_sheet_date']);
$this->params['breadcrumbs'][] = ['label' => 'Balance Amounts for '.$session['balance_sheet_date'], 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-amount-view">

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
            'amount',
            'balance_item_id',
            'balance_sheet_id',
        ],
    ]) ?>

</div>
