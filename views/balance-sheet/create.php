<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BalanceSheet */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Balance Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance History'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-sheet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
