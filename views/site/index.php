<?php
use yii\helpers\Html;
use app\components\BalanceTotals;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Home Finance');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= $this->title ?></h1>
		<p>
			<?= Yii::t('app', 'Manage your money professionally!') ?>
		</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <h2><?= Yii::t('app', 'Totals') ?></h2>
				
				<?= BalanceTotals::widget() ?>
                
            </div>
            <div class="col-lg-6 text-right">
				<h2><?= Yii::t('app', 'Wizards') ?></h2>
				<p>	<?= Html::a(Yii::t('app', 'Init wizard'), 
					['process/start', 'process_code'=>'init'], 
					['class'=>'btn btn-success']) ?> </p>
				<p>
					<?= Html::a(Yii::t('app', 'Drop my data'), 
					['site/drop', 'process_code'=>'init'], 
					['class'=>'btn btn-danger', 
					'data' => ['confirm' => Yii::t('yii', 'Are you sure you want to delete this item?')],]) ?>
				</p>
            </div>
        </div>

    </div>
</div>
