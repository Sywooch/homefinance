<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceAmount */

$this->title = 'Update Balance Amount: ' . ' ' . $model->id;

$session = Yii::$app->session;
$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/index'),'label'=>'Balance Sheets');
$this->params['breadcrumbs'][] = array('url'=>array('balance-sheet/view', 'id'=>$session['balance_sheet_id']),'label'=>$session['balance_sheet_date']);
$this->params['breadcrumbs'][] = ['label' => 'Balance Amounts for '.$session['balance_sheet_date'], 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="balance-amount-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
