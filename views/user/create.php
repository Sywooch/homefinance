<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = Yii::t('app', 'Register');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<div class="row">
	<div class="col-lg-9">
	
	<h2><?= Yii::t('app', 'Fill the Form') ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
	
	</div><div class="col-lg-3">
	
	<h2><?= Yii::t('app', 'or sign with Google') ?></h2>
	<br/>
	<?= yii\authclient\widgets\AuthChoice::widget([
		 'baseAuthUrl' => ['site/auth'],
		 'popupMode' => false,
	]) ?>
	
	</div></div>
</div>
