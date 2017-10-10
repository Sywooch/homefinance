<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
	<? $this->beginBlock('landing-script'); ?>
	$(document).ready(function() {
		$('#fullpage').fullpage(<?= $this->params['fullpageParams'] ?>);
	});
	<? $this->endBlock(); ?>
	</script>
	<?
	$this->registerCssFile('@web/css/jquery.fullPage.css');
	$this->registerJsFile('@web/js/jquery.fullPage.js', ['depends'=>[\yii\web\JqueryAsset::className()]]);
	$this->registerJs($this->blocks['landing-script'], $this::POS_END);
	?>
    <? Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?
NavBar::begin([
	'brandLabel' => Yii::t('app', 'Home Finance'),
	'brandUrl' => '#home',
	'options' => [
		'class' => 'navbar-inverse navbar-fixed-top',
	],
]);
echo Nav::widget([
	'options' => ['class' => 'navbar-nav navbar-right'],
	'items' => $this->params['nav_links'],
]);
NavBar::end();
?>

<div id="fullpage">
	<?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
