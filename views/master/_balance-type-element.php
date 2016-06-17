<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>


<div>
<h3><?= Html::a('+', ['add-balance-item', 'type_id' => $bType->id], ['class' => 'btn btn-success'])." ".$bType->name ?></h3>
	<div>
	<?php 
	if ($bType->balanceItems) {
		$item_name = "";
		$bSheet = 0;
		/*****************
		BalanceItems array - each for Balance Item x Balance Sheet
		
		******************/
		// for each item from BalanceItems view
		for ($i = 0; $i < count($bType->balanceItems); $i++) {
			$item = $bType->balanceItems[$i];
			// if this is new item start new
			if ($item_name != "") echo Html::EndTag("div");
			if ($item->name != $item_name)
			{
				$item_name = $item->name;
	?>
		<div class="row">
			<div class="col-sm-2">
				<?php
					echo Html::a('x', ['remove-balance-item', 'id' => $item->id], ['class' => 'btn btn-danger']);
					echo Html::a('>', ['details-balance-item', 'item_id' => $item->id], ['class' => 'btn btn-primary']);
				?>
			</div>
			<div class="col-sm-4"> <?= $item->name ?> </div>
	<?php
			}
			// for each required balance sheet
			for ($bSheet = 0; $bSheet < count(Yii::$app->session['balanceSheets']); $bSheet++) {
				echo Html::beginTag("span", ['class'=>'col-sm-3 col-xs-6']);
				$value = $item->getAmount(Yii::$app->session['balanceSheets'][$bSheet]->id);
				if (!$value) echo $item->showCreateLink(Yii::$app->session['balanceSheets'][$bSheet]);
				else if ($item->accounts_number > 1) echo $value;
				else {
					Modal::begin([
						'header' => $item->name.' '.Yii::$app->session['balanceSheets'][$bSheet]->period_start,
						'toggleButton' => ['tag'=>'a', 'label' => $value, 'class'=>'modal_edit'],
					]);
					//TODO: extract logic from here!
					$model = $item->accounts[0]->getBalanceAmounts()->where(['balance_sheet_id'=>Yii::$app->session['balanceSheets'][$bSheet]->id])->one();
					echo $this->render('/balance-amount/_form_master', ['model' => $model]);
					Modal::end();
				}
				echo Html::endTag("span");
			}
		}
?>
</div>
<?php
	} else {
		echo "no items";
	}
	?>
	</div>
</div>