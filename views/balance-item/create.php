<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BalanceItem */

$this->title = 'Create Balance Item';
$this->params['breadcrumbs'][] = ['label' => 'Balance Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
