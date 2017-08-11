<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
	
	<div class="row">
		<div class="col-lg-4"></div>
		<div class="col-lg-4 text-center panel panel-default">
			<h1 class="panel-heading"><?= Html::encode($this->title) ?></h1>
			
			<div class="panel-body">
			<?php $form = ActiveForm::begin(); ?>

				<?= $form->field($model, 'username') ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
			
				<div class="form-group">
					<?= Html::a('Register', ['user/create'], ['class' => 'btn btn-primary']) ?>
					<?= Html::submitButton('Login', ['class' => 'btn btn-success']) ?>
				</div>
			<?php ActiveForm::end(); ?>

			------------- ИЛИ ------------
			
			<?= yii\authclient\widgets\AuthChoice::widget([
				 'baseAuthUrl' => ['site/auth'],
				 'popupMode' => false,
			]) ?>
			</div>
		</div>
		<div class="col-lg-4"></div>
	</div>
</div>
