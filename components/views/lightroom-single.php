<?php
use yii\bootstrap\Modal;

/* @var $this Widget */
/* @var $toggle String */
/* @var $image_url String */
/* @var $header_title String */

Modal::begin([
    'header' => $header_title,
    'toggleButton' => ['tag'=>'div', 'label' => $toggle],
]);
?>
<div>
<img style="width:95%;" src="<?= $image_url?>">
</div>
<?php
Modal::end();
$this->registerJs("$('.modal').detach().appendTo('body');");