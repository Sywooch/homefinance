<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */
/* @var $step app\models\BasicProcess::step */

$this->title = $step->title;
?>
<p class="lead"><?=$model->title ?></p>
<div>
	<link rel="stylesheet" href="css/wizard.css">
	<script src="js/wizard.js"></script>
	<script>
		var current_stage = '<?= $step->stage ?>';
		var header = [
			{title: "Введение", is_active: current_stage.includes("Введение")},
			{title: "Активы", is_active: current_stage.includes("Активы")},
			{title: "Пассивы", is_active: current_stage.includes("Пассивы")},
		];
		var active = [
			{title: "Высоколиквидные", is_active: current_stage.includes("Высоколиквидные")},
			{title: "Среднеликвидные", is_active: current_stage.includes("Среднеликвидные")},
			{title: "Низколиквидные", is_active: current_stage.includes("Низколиквидные")}
		];
		var passive = [
			{title: "Свои средства", is_active: current_stage.includes("Свои средства")},
			{title: "Резервы", is_active: current_stage.includes("Резервы")},
			{title: "Обязательства", is_active: current_stage.includes("бязательства")}
		];
		createWizard(header);
		if (current_stage.includes("Активы")) createWizard(active);
		if (current_stage.includes("Пассивы")) createWizard(passive);
	</script>
</div>
<div class="row">
	<h1 class="col-lg-6"><?=$step->title?> <span class="small glyphicon glyphicon-info-sign" title="<?= $step->stage ?>"></span></h1>
	<p class="col-lg-6">
		
	</p>
</div>
<p>
    <?= $step->message ?>
</p>
<? if (isset($step->buttons) && $step->buttons == 'yesno') { ?>
<p>
	<strong>Учитывать <?= $step->title?>?</strong>
</p>
<? } ?>

<?php $form = ActiveForm::begin(); ?>

<? if (isset($step->error) && $step->error > '') { ?>
<p class="mark bg-danger text-danger">
	<?= $step->error ?>
</p>
<? } ?>

<?php
if (isset($step->buttons)) {
	if ($step->buttons == 'yesno') {
		echo $this->render('_btn_yesno');
	} else echo $this->render('_btn_submit');
} else echo $this->render('_btn_submit');
?>


<?php ActiveForm::end(); ?>