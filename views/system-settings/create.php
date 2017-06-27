<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\SystemSettings */

$this->title = 'Create System Settings';
$this->params['breadcrumbs'][] = ['label' => 'System Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
