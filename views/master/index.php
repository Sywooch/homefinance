<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = "Accounting Master";
?>
<h1>Accounting Master</h1>

<div class="master_balance">
	<div class="col-lg-6">
		<?php
			echo Html::a("New month", ['balance-sheet/create-next'], ['class'=>'col-md-6']);
			foreach($balanceSheets as $s)
			{
				echo Html::tag("span", $s->period_start, ['class'=>'col-xs-3']);
			}
		?>
		<div>
			<h2>Активы</h2>
			<div>
				<?php
					$i = 0;
					while ($balanceTypes[$i]->is_active) {
						echo $this->render("_balance-type-element",['bType'=>$balanceTypes[$i]]);
						$i++;
					}
				?>
			</div>
			<h2>Пассивы</h2>
			<div>
				<?php
					while ($i < count ($balanceTypes)) {
						echo $this->render("_balance-type-element",['bType'=>$balanceTypes[$i]]);
						$i++;
					}
				?>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<h2>Cashflow</h2>
	</div>
</div>