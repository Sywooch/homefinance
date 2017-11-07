<?php

use yii\helpers\Html;
use yii\authclient\widgets\AuthChoice;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

	<div class="row">
		<div class="col-lg-4 col-lg-offset-4 text-center panel panel-default">
			<h1 class="panel-heading"><?= Html::encode($this->title) ?></h1>
			<div class="panel-body">
				<?= $this->render('_form', [
					'model' => $model,
				]) ?>
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
