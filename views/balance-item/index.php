<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $typesList app\models\BalanceItem */
/* @var $bSheets app\models\BalanceSheet */
/* @var $dataProviders[] yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Current Balance');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-index">

    <h1><?= Html::encode($this->title) ?></h1>
	
    <p>
        <?= Html::a(Yii::t('app', 'New Month'), ['balance-sheet/create-next'], ['class' => 'btn btn-success']) ?>
		
		<?= Html::a(Yii::t('app', 'Verify Change'), ['balance-sheet/verify-change', 'id'=>$bSheets[0]->id], ['class' => 'btn btn-default']) ?>
		
		<?= Html::a(Yii::t('app', 'Upload Transactions'), ['transaction/upload'], ['class' => 'btn btn-default']) ?>
		
		<?= Html::a(Yii::t('app', 'New Balance Item'), ['create'], ['class' => 'btn btn-default']) ?>
    </p>
	
	<?= $this->render('_cat_list', [
		'typesList' => $typesList,
		'bSheets' => $bSheets,
		'dataProviders' => $dataProviders,
	]) ?>
</div>