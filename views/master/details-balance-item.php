<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use app\models\BalanceAmount;
use yii\bootstrap\Modal;

$this->title = $item->name;
$balanceSheets = Yii::$app->session['balanceSheets'];
?>
<h1><?= $item->name ?></h1>
<?php
echo Html::a('<', ['master/index'], ['class' => 'btn btn-primary']);
echo Html::a('+', ['account/create'], ['class' => 'btn btn-success']);
?>
<div class="item_details_balance">
	<div class="sheets_dates">
	<span class="sheet_head_details"></span>
	<?php
		foreach($balanceSheets as $s)
		{
			echo Html::tag("span", $s->period_start, ['class'=>'sheet_head']);
		}
	?>
	</div>
	<div class="balance-item-element">
		<div class="list">
		<?php 
		if ($item->accounts) {
			$bSheet = 0;
			// for each from accounts
			for ($i = 0; $i < count($item->accounts); $i++) {
				$account = $item->accounts[$i];
				echo Html::beginTag("div", ['class'=>'balance-item']);
				echo Html::a('x', ['account/delete', 'id' => $account->id], ['class' => 'btn btn-danger']);
				echo Html::tag("span", $account->name, ['class'=>'item_name']);
				
				// for each required balance sheet
				for ($bSheet = 0; $bSheet < count(Yii::$app->session['balanceSheets']); $bSheet++) {
					echo Html::beginTag("span", ['class'=>'item_amount']);
					//find amount
					$amount = BalanceAmount::find()->where([
						'account_id'=>$account->id,
						'balance_sheet_id'=>Yii::$app->session['balanceSheets'][$bSheet]->id
					])->one();
					// if found show and edit, else - show create
					if ($amount) {
						Modal::begin([
							'header' => $account->name.' '.Yii::$app->session['balanceSheets'][$bSheet]->period_start,
							'toggleButton' => ['tag'=>'a', 'label' => $amount->amount],
						]);
						echo $this->render('/balance-amount/_form_master', ['model' => $amount]);
						Modal::end();
					} else {
						echo "create";
					}
					echo Html::endTag("span");
				}
				echo Html::endTag("div");
			}
		} else {
			echo "no items";
		}
		?>
		</div>
	</div>
</div>

