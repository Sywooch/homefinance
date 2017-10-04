<?php
namespace app\components;

use yii\base\Widget;
use app\models\BalanceItemExt;
use app\models\BalanceSheet;

class BalanceTotals extends Widget {
	private $bSheet;
	private $typesList;
	
	public function init() {
        $this->bSheet = BalanceSheet::lastN(1)[0];
		if ($this->bSheet->period_start != 'not set') {
			$this->typesList = BalanceItemExt::findTypesList()->
				joinWith('balanceType')->
				andWhere(['balance_type_category_id' => 2])->
				orderBy(false)->
				all();
		}
	}
	
	public function run() {
		if ($this->bSheet->period_start != 'not set') {
			return $this->render('balance-totals', [
				'bSheet' => $this->bSheet,
				'typesList' => $this->typesList,
			]);
		} else {
			return \Yii::t('app', 'Create balance to view the totals');
		}
	}
}
?>