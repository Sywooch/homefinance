<?
use yii\helpers\Html;
use app\components\LandingFormCreateWidget;

$user = Yii::$app->user;

$this->title = Yii::t('app', 'Home Finance');
$this->params['fullpageParams'] = "";//"{anchors:['home', 'finanalysis', 'opportunities']}";
$this->params['nav_links'] = [
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
];
?>
<div class="section">
	<div class="row">
	<div class="text-center col-lg-10 col-lg-offset-1">
		<h1 class="text-center"><?= $this->title ?></h1>
		<p><span class="h3">Новая возможность для решения стратегических финансовых задач</span>
		<p>	<?= Html::a(Yii::t('app', 'Init wizard'), 
					['process/perform', 'process_code'=>'init', 'step_code'=>'init1'], 
					['class'=>'btn btn-success']) ?> </p>
		</p>
	</div>
	</div>
</div>