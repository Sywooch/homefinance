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
	<?php
		//$this->registerCssFile("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
		//$this->registerJsFile('//code.jquery.com/ui/1.11.4/jquery-ui.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
	?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', 'Home Finance'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	$user = Yii::$app->user;
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
			['label' => Yii::t('app', 'Current Balance'), 'url' => ['/balance-item/index']],
			['label' => Yii::t('app', 'Balance History'), 'url' => ['/balance-sheet/index']],
			['label' => Yii::t('app', 'Transactions'), 'url' => ['/transaction/index']],
			['label' => 'Unit Tests', 
				'visible' => !$user->isGuest && $user->identity->isAdmin,
				'items' => [
					['label' => 'Accounts', 'url' => ['/account/index']],
					['label' => 'User Settings', 'url' => ['/user-settings/index']],
					['label' => 'Import Settings', 'url' => ['/import-settings/index']],
				]
			],
			['label' => 'Admin', 
				'visible' => !$user->isGuest && $user->identity->isAdmin,
				'items' => [
					['label' => 'Users', 'url' => ['/user/index']],
					['label' => 'Ref Balance Items', 'url' => ['/ref-balance-item/index']],
					['label' => 'Knowledge Articles', 'url' => ['/knowledge-article/index']],
					['label' => 'Balance Types', 'url' => ['/balance-type/index']],
					['label' => 'Balance Type Categories', 'url' => ['/balance-type-category/index']],
					['label' => 'System Settings', 'url' => ['/system-settings/index']],
				]
			],
			['label' => Yii::t('app', 'Login'), 'url' => ['/site/login'], 'visible' => $user->isGuest],
			['label' => !$user->isGuest ? $user->identity->username : '', 
				'visible' => !$user->isGuest,
				'items' => [
					['label'=>Yii::t('app', 'My Profile'), 'url'=>['/user/view-profile']],
					[
						'visible' => !$user->isGuest,
						'label' => Yii::t('app', 'Logout'),
						'url' => ['/site/logout'],
						'linkOptions' => ['data-method' => 'post']
					],
				]
			],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('app', 'Home Finance') ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
