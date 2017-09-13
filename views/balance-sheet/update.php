<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceSheet */

$this->title = Yii::t('yii', 'Update') . ' ' . Yii::t('app', 'Balance Sheet') . ': ' . $model->period_start;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance History'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->period_start, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yii', 'Update');
?>
<div class="balance-sheet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
