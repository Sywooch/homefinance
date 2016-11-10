<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */

$this->title = 'Завершен '.$model->title;
?>
<h1><?= $this->title ?></h1>

<p>
    <?= $model->finishMessage?>
</p>
<p>
	<?= Html::a($model->finishLink[0],$model->finishLink[1],['class'=>'btn btn-success']) ?>
</p>
