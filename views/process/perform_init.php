<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */
/* @var $step app\models\BasicProcess::step */

$this->title = $step->title;
?>
<p class="lead"><?=$model->title ?></p>
<div class="wizard-wrapper">
	<link rel="stylesheet" href="css/wizard.css">
	<script src="js/wizard.js"></script>
	<script>
		var current_stage = '<?= $step->stage ?>';
		var header = [
			{title: "Введение", is_active: current_stage.includes("Введение")},
			{title: "Активы", is_active: current_stage.includes("Активы")},
			{title: "Пассивы", is_active: current_stage.includes("Пассивы")},
		];
		createWizard(header);
		
		var found_step = false;
		
		function display_step_icon(step) {
			var icon = "ok";
			if (found_step || current_stage.includes("Введение")) icon = "arrow-right";
			else if (current_stage.toLowerCase().includes(step.toLowerCase())) {
				icon = "pencil";
				found_step = true;
			}
			document.write("<span class='wizard-"+icon+"-icon glyphicon glyphicon-"+icon+"'></span> "+step);
		}
	</script>
	<div class="row">
		<div class="col-lg-4">
		</div>
		<div class="col-lg-4">
			<ul class="list-unstyled">
				<li>
				<script>
				display_step_icon("Высоколиквидные");
				</script>
				</li>
				<li>
				<script>
				display_step_icon("Среднеликвидные");
				</script>
				</li>
				<li>
				<script>
				display_step_icon("Низколиквидные");
				</script>
				</li>
			</ul>
		</div>
		<div class="col-lg-4">
			<ul class="list-unstyled">
				<li>
				<script>
				display_step_icon("Свои средства");
				</script>
				</li>
				<li>
				<script>
				display_step_icon("Резервы");
				</script>
				</li>
				<li>
				<script>
				display_step_icon("Обязательства");
				</script>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
	<h1 class="col-lg-6"><?=$step->title?> <span class="small glyphicon glyphicon-info-sign" title="<?= $step->stage ?>"></span></h1>
</div>
<div class="row">
	<div class="col-lg-4 pull-right">
		<img class="img-responsive" src="http://profmeter.com.ua.opt-images.1c-bitrix-cdn.ru/upload/medialibrary/813/540 - АктивИПассив.jpg?136370154362347"/>
	</div>
	<div class="col-lg-8">
		<p>
			<?= $step->message ?>
		</p>

		<?php $form = ActiveForm::begin(); ?>

		<? if (isset($step->buttons) && $step->buttons == 'yesno') { ?>
		<p>
			<strong>Учитывать <?= $step->title?>?</strong>
		</p>
		<label>Сколько сейчас?</label>
		<input type="text" name="init_value" value="0"/>
		<? } ?>

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

	</div>
</div>