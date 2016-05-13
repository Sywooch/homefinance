<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;

?>


<div class="balance-type-element">
<h3><?= $bType->name." ".Html::a('+', ['add-balance-item', 'type_id' => $bType->id], ['class' => 'btn btn-success']) ?></h3>
	<div class="list">
	<?php 
	if ($bType->balanceItems) {
		$item_name = "";
		$bSheet = 0;
		// for each item from BalanceItems view
		for ($i = 0; $i < count($bType->balanceItems); $i++) {
			$item = $bType->balanceItems[$i];
			// if this is new item start new
			if ($item->name != $item_name)
			{
				if ($item_name != "") echo Html::endTag("div");
				echo Html::beginTag("div", ['class'=>'balance-item']);
				$item_name = $item->name;
				echo Html::a('x', ['remove-balance-item', 'id' => $item->id], ['class' => 'btn btn-danger']);
				echo Html::a('>', ['details-balance-item', 'item_id' => $item->id], ['class' => 'btn btn-primary']);
				echo Html::tag("span", $item->name, ['class'=>'item_name']);
			}
			$raisedIndex = false;
			// for each required balance sheet
			for ($bSheet = 0; $bSheet < count(Yii::$app->session['balanceSheets']); $bSheet++) {
				echo Html::beginTag("span", ['class'=>'item_amount']);
				//if item->period_start is null show create and continue = means that there is no amounts at all
				if ($i >= count($bType->balanceItems) || $item->period_start == null) {
					echo $item->showCreateLink(Yii::$app->session['balanceSheets'][$bSheet]);
					echo Html::endTag("span");
					continue;
				}
				//get next
				$item = $bType->balanceItems[$i];
				// if still same item
				if ($item->name == $item_name) {
					//if item->period_start equals session->period_start show amount, set next item
					if (Yii::$app->session['balanceSheets'][$bSheet]->period_start == $item->period_start) {
						// if more than 1 account just show, else show with edit
						if ($item->accounts_number > 1) echo $item->amount;
						else {
							Modal::begin([
								'header' => $item->name.' '.Yii::$app->session['balanceSheets'][$bSheet]->period_start,
								'toggleButton' => ['tag'=>'a', 'label' => $item->amount],
							]);
							$model = $item->accounts[0]->getBalanceAmounts()->where(['balance_sheet_id'=>Yii::$app->session['balanceSheets'][$bSheet]->id])->one();
							echo $this->render('/balance-amount/_form_master', ['model' => $model]);
							Modal::end();
						}
						$i++;
						$raisedIndex = true;
					} else {
						//else show create
						echo $item->showCreateLink(Yii::$app->session['balanceSheets'][$bSheet]);
					}
				}
				echo Html::endTag("span");
			}
			if ($raisedIndex) $i--;
		}
		echo Html::endTag("div");
	} else {
		echo "no items";
	}
	?>
	</div>
</div>