<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = "Accounting Master";
?>
<h1>Accounting Master</h1>

<div class="master_balance">
	<div class="sheets_dates">
	<span class="sheet_head_master"></span>
	<?php
		foreach($balanceSheets as $s)
		{
			echo Html::tag("span", $s->period_start, ['class'=>'sheet_head']);
		}
	?>
	</div>
	<div class="items_data">
		<h2>Активы</h2>
		<div class="balance_block">
			<?php
				$i = 0;
				while ($balanceTypes[$i]->is_active) {
					echo $this->render("_balance-type-element",['bType'=>$balanceTypes[$i]]);
					$i++;
				}
			?>
		</div>
		<h2>Пассивы</h2>
		<div class="balance_block">
			<?php
				while ($i < count ($balanceTypes)) {
					echo $this->render("_balance-type-element",['bType'=>$balanceTypes[$i]]);
					$i++;
				}
			?>
		</div>
	</div>
</div>