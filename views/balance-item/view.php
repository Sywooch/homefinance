<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BalanceItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Current Balance'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balance-item-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
		<? if (!$model->immutable) { ?>
			<?= Html::a(Yii::t('yii', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('yii', 'Delete'), ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
					'method' => 'post',
				],
			]) ?>
		<? } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_code',
            'name',
			'balanceType.name:text:'.$model->attributeLabels()['balance_type_id'],
        ],
    ]) ?>

</div>
<?
if (isset($model->ref_balance_item_id) && isset($model->refBalanceItem->knowledge_article_id)) {
	$article = $model->refBalanceItem->knowledgeArticle;
?>
	<div class="row">
		<div class="col-lg-4 pull-right">
			<img class="img-responsive" style="margin-bottom:5px;" src="<?= $article->image_url ?>"/>
		</div>
		<div class="col-lg-8" style="vertical-align:center;">
			<p>
				<?= $article->full_text ?>
			</p>
		</div>
	</div>
<? } ?>
