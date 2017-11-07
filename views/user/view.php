<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
if ($action != 'view-profile') $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('yii', 'Update'),
		$action == 'view-profile' ?
		['update-profile'] :
		['update', 'id' => $model->id],
		['class' => 'btn btn-primary']) ?>
        <?= $action == 'view' ? Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) : '' ?>
		<?= $action == 'view-profile' ? Html::a(Yii::t('app', 'Drop my data'), 
			['site/drop', 'process_code'=>'init'], 
			['class'=>'btn btn-danger', 
			'data' => ['confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')],
		]) : '' ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            'email:email',
			'create_datetime:datetime',
        ],
    ]) ?>

</div>
