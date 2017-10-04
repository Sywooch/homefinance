<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceSheet */
/* @var $typesList app\models\BalanceItem */
/* @var $bSheets app\models\BalanceSheet */
/* @var $dataProviders[] yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Balance Sheet') . ' ' . Yii::$app->formatter->asDate($model->period_start);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Balance History'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-sheet-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<? /* Html::a('Verify Balance Change', ['verify-change', 'id' => $model->id], ['class' => 'btn btn-success']) */ ?>
    </p>

    <?= $this->render('/balance-item/_cat_list', [
		'typesList' => $typesList,
		'bSheets' => $bSheets,
		'dataProviders' => $dataProviders,
	]) ?>

</div>
