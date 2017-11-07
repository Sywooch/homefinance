<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = Yii::t('app', 'Login');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
	
	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 text-center panel panel-default">
			<h1 class="panel-heading"><?= Html::encode($this->title) ?></h1>
			
			<div class="panel-body">
			<?php $form = ActiveForm::begin(); ?>

				<?= $form->field($model, 'username') ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
			
				<div class="form-group">
					<?= Html::a(Yii::t('app', 'Register'), ['user/create'], ['class' => 'btn btn-primary']) ?>
					<?= Html::submitButton(Yii::t('app', 'Login'), ['class' => 'btn btn-success']) ?>
				</div>
			<?php ActiveForm::end(); ?>

			------------- <?= Yii::t('app', 'OR') ?> ------------
			
			<?php $authAuthChoice = AuthChoice::begin([
			    'baseAuthUrl' => ['site/auth']
			]); ?>
			<div class="text-center">
			<?php foreach ($authAuthChoice->getClients() as $client): ?>
			    <?= $authAuthChoice->clientLink($client) ?>
			<?php endforeach; ?>
			</div>
			<?php AuthChoice::end(); ?>
			</div>
		</div>
	</div>
</div>
