<?php
use yii\helpers\Html;

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
            <div class="col-lg-4 text-center">
                <h2>TBD</h2>

                
            </div>
            <div class="col-lg-4 text-center">
				<h2>Processes</h2>
				<p>
					<?= Html::a('Init', ['process/start', 'process_code'=>'init'], ['class'=>'btn btn-success']) ?>
					<?= Html::a('Drop all data', ['site/drop', 'process_code'=>'init'], ['class'=>'btn btn-danger', 'data' => ['confirm' => 'Are you sure?'],]) ?>
				</p>
            </div>
            <div class="col-lg-4 text-center">
                <h2>TBD</h2>

                <p></p>

            </div>
        </div>

    </div>
</div>
