<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BalanceTypeCategory */

$this->title = 'Create Balance Type Category';
$this->params['breadcrumbs'][] = ['label' => 'Balance Type Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-type-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
