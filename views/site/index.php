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
            <div class="col-lg-6 col-lg-offset-3 text-center">
                <h2><?= Yii::t('app', 'Totals') ?></h2>
				
				<?= BalanceTotals::widget() ?>
                
            </div>
        </div>

    </div>
</div>
