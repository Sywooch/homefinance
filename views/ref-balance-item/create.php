<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\RefBalanceItem */

$this->title = 'Create Ref Balance Item';
$this->params['breadcrumbs'][] = ['label' => 'Ref Balance Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-balance-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
