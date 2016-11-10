<?php
namespace app\components;

use yii\base\Widget;
use app\models\BalanceItem;
use app\models\Account;

class AccountValue extends Widget {
	public $model;
	public $attribute;
	
	private $amount;

	public function init() {
        if ($this->model->accounts_number == 1) {
			$this->amount = $this->model->accounts[0]->__get($this->attribute);
		}
	}
	
	public function run() {
        return $this->render('AccountValue', [
			'model' => $this->model,
			'attribute' => $this->attribute,
			'amount' => $this->amount,
		]);
	}
}
?>