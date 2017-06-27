<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ImportSettings */

$this->title = 'Create Import Settings';
$this->params['breadcrumbs'][] = ['label' => 'Import Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-settings-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
