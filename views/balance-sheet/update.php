<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceSheet */

$this->title = 'Update Balance Sheet: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Balance Sheets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->period_start, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="balance-sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
