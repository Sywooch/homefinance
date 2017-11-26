<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BalanceItem */

$this->title = Yii::t('app', 'Create') . ' ' . Yii::t('app', 'Balance Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-create">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<p>Можно создать счет вручную, но удобнее воспользоваться мастером-помощником. <?= Html::a('Запустить', ['process/start', 'process_code'=>'init']) ?>?</p>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
