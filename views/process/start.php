<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BasicProcess */

$this->title = $model->title;
?>
<h1><?= $this->title ?></h1>

<p>
    <?= $model->description?>
</p>
<p>
	<?= Html::a('Start', ['perform', 'process_code'=>$model->code, 'step_code'=>$model->steps[0]->code], ['class' => 'btn btn-success']) ?>
</p>