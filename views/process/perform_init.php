<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */
/* @var $step app\models\BasicProcess::step */
/* @var $article app\models\KnowledgeArticle */

$this->title = $article->name;
?>
<p class="lead" style="margin-bottom:5px;"><?=$model->title ?> 
<span id="chevrons-wrapper" class="btn btn-default" title="<?= $step->stage ?>">
	<span class="wizard-next-icon glyphicon glyphicon-chevron-right" id="chevron_1"></span>
	<span class="wizard-next-icon glyphicon glyphicon-chevron-right" id="chevron_2"></span>
	<span class="wizard-next-icon glyphicon glyphicon-chevron-right" id="chevron_3"></span>
</span>
</p>
<div class="wizard-wrapper">
	<link rel="stylesheet" href="css/wizard.css">
	<script src="js/wizard.js"></script>
	<script>
		var current_stage = '<?= $step->stage ?>';
		var current_step_code = '<?= $step->code ?>';
		var header = [
			{title: "Введение", is_active: current_stage.includes("Введение")},
			{title: "Активы", is_active: current_stage.includes("Активы")},
			{title: "Пассивы", is_active: current_stage.includes("Пассивы")},
		];
		createWizard(header);
		
		var found_step = false;
		
		// called from each step
		function display_step_icon(step) {
			var icon = "ok";
			var related_stage = "prev";
			if (found_step || current_stage.includes("Введение")) {
				icon = "arrow-right";
				related_stage = "next";
			} else if (current_stage.toLowerCase().includes(step.toLowerCase())) {
				icon = "pencil";
				found_step = true;
				related_stage = "current";
			}
			if (related_stage == "current") document.write("<strong>");
			document.write("<span class='wizard-"+related_stage+"-icon glyphicon glyphicon-"+icon+"'></span> "+step);
			if (related_stage == "current") document.write("</strong>");
		}
		
		// manage chevrons and hide full stage
		function initStagesView() {
			applyChevronsColor();
			//hide for mobile
			if (window.innerWidth < 500) {
				$(".wizard-wrapper").hide();
			}
			//do not hide at any stage for desktop
			/*
			if (current_step_code == 'init1') {
				// do not hide automatically
			} else if (current_step_code == 'init2') {
				// hide with timeout
				setTimeout(showHideStages, 1000);
			} else {
				//hide immediately
				$(".wizard-wrapper").hide();
			}*/
			$("#chevrons-wrapper").click(showHideStages);
		}
		
		function showHideStages() {
			var stages = $(".wizard-wrapper");
			if (stages.is(":visible")) stages.hide("slow");
			else stages.show("fast");
		}
		
		function applyChevronsColor () {
			if (current_stage.includes("Введение")) {
				$("#chevron_1").removeClass("wizard-next-icon").addClass("wizard-current-icon");
			} else {
				$("#chevron_1").removeClass("wizard-next-icon").addClass("wizard-prev-icon");
				if (current_stage.includes("Активы")) {
					$("#chevron_2").removeClass("wizard-next-icon").addClass("wizard-current-icon");
				} else {
					$("#chevron_2").removeClass("wizard-next-icon").addClass("wizard-prev-icon");
					if (current_stage.includes("Пассивы")) {
						$("#chevron_3").removeClass("wizard-next-icon").addClass("wizard-current-icon");
					} else {
						$("#chevron_3").removeClass("wizard-next-icon").addClass("wizard-prev-icon");
					}
				}
			}
		}
	</script>
	<? $this->registerJs("initStagesView ();"); ?>
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
	<h1 class="col-lg-6"><?=$article->name?></h1>
</div>
<div class="row">
	<div class="col-lg-4 pull-right">
		<img class="img-responsive" style="margin-bottom:5px;" src="<?= $article->image_url ?>"/>
	</div>
	<div class="col-lg-8" style="vertical-align:center;">
		<p>
			<?= $article->full_text ?>
		</p>

		<?php $form = ActiveForm::begin(); ?>

		<? if (isset($step->buttons) && $step->buttons == 'yesno') { ?>
		<label>Текущая сумма на счету/задолженность: </label>
		<input type="text" name="init_value" value="0"/>
		<p>
			<strong>Учитывать <?= $article->name?>?</strong>
		</p>
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