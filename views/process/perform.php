<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */
/* @var $step app\models\BasicProcess::step */

$this->title = $step->title;
?>
<p class="lead"><?=$model->title ?></p>

<h1><?=$step->title?></h1>

<p>
    <?= $step->message ?>
</p>

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