<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\KnowledgeArticle */

$this->title = 'Create Knowledge Article';
$this->params['breadcrumbs'][] = ['label' => 'Knowledge Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="knowledge-article-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
