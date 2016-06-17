<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use app\models\BalanceAmount;
use yii\bootstrap\Modal;

$this->title = $item->name;
$balanceSheets = Yii::$app->session['balanceSheets'];
?>
<h1><?= $item->name ?></h1>
<div class="item_details_balance">
	<div class="col-lg-6">
		<h2>Список счетов</h2>
		<div class="col-md-6">
		<?php
			echo Html::a('<', ['master/index'], ['class' => 'btn btn-primary']);
			echo Html::a('+', ['account/create'], ['class' => 'btn btn-success']);
		?>
		</div>
		<?php
			foreach($balanceSheets as $s)
			{
				echo Html::tag("span", $s->period_start, ['class'=>'col-xs-3']);
			}
		?>
		<div class="col-xs-12">
			<?php 
			if ($item->accounts) {
				$bSheet = 0;
				// for each from accounts
				for ($i = 0; $i < count($item->accounts); $i++) {
					$account = $item->accounts[$i];
					
					echo Html::a('x', ['account/delete', 'id' => $account->id], ['class' => 'btn btn-danger']);
					echo Html::tag("span", $account->name, ['class'=>'col-xs-4']);
					
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
	<div class="col-lg-6">
		<h2>Cashflow</h2>
	</div>
</div>

