<?php
namespace app\components;

use yii\base\Widget;
use app\models\BalanceItem;
use app\models\Account;

class AccountValue extends Widget {
	public $bItemModel;
	public $bSheet_id;
	
	private $amountModel;

	public function init() {
        if ($this->bItemModel->getAccounts()->count() == 1) {
			$this->amountModel = $this->bItemModel->accounts[0]->getAmountModel($this->bSheet_id);
		}
	}
	
	public function run() {
        return $this->render('account-value', [
			'bItemModel' => $this->bItemModel,
			'bSheet_id' => $this->bSheet_id,
			'amountModel' => $this->amountModel,
		]);
	}
}
?>