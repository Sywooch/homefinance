<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BalanceType */

$this->title = 'Create Balance Type';
$this->params['breadcrumbs'][] = ['label' => 'Balance Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
