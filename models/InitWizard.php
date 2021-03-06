<?php

namespace app\models;

use Yii;
use \yii\helpers\Json;

class InitWizard extends BasicProcess
{
	public $code = 'init';
	public $title = 'Быстрый старт';
	public $description = 'Этот мастер поможет вам быстро начать управлять вашими деньгами';
	public $finishMessage = 'Спасибо за использование мастера. Мы подготовили ваш бухгалтерский баланс - представление ваших финансов в разрезе активов и пассивов. Баланс показывает текущее состояние на определенную дату, мы рекомендуем обновлять его раз в месяц.';
	public $finishLink = ['Просмотреть статус по всем счетам', ['balance-item/index']];
	public $steps = [
		[
			'code'=>'init1',
			'article'=>1,
			'ref_balance_item'=>'',
			'stage'=>'Введение',
			'buttons'=>'submit',
		],
		[
			'code'=>'init2',
			'article'=>2,
			'stage'=>'Активы - Высоколиквидные',
			'ref_balance_item'=>2,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init3',
			'article'=>3,
			'stage'=>'Активы - Высоколиквидные',
			'ref_balance_item'=>3,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init4',
			'article'=>4,
			'stage'=>'Активы - Высоколиквидные',
			'ref_balance_item'=>4,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init5',
			'article'=>5,
			'stage'=>'Активы - Среднеликвидные',
			'ref_balance_item'=>5,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init6',
			'article'=>6,
			'stage'=>'Активы - Среднеликвидные',
			'ref_balance_item'=>6,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init7',
			'article'=>7,
			'stage'=>'Активы - Низколиквидные',
			'ref_balance_item'=>7,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init71',
			'article'=>8,
			'stage'=>'Пассивы - Свои средства',
			'ref_balance_item'=>'',
			'buttons'=>'submit',
		],
		[
			'code'=>'init8',
			'article'=>9,
			'stage'=>'Пассивы - Свои средства',
			'ref_balance_item'=>'',
			'buttons'=>'submit',
		],
		[
			'code'=>'init9',
			'article'=>10,
			'stage'=>'Пассивы - Свои средства',
			'ref_balance_item'=>10,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init10',
			'article'=>11,
			'stage'=>'Пассивы - Резервы',
			'ref_balance_item'=>11,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init11',
			'article'=>12,
			'stage'=>'Пассивы - Резервы',
			'ref_balance_item'=>12,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init12',
			'article'=>13,
			'stage'=>'Пассивы - Резервы',
			'ref_balance_item'=>13,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init13',
			'article'=>14,
			'stage'=>'Пассивы - Краткосрочные обязательства',
			'ref_balance_item'=>14,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init14',
			'article'=>15,
			'stage'=>'Пассивы - Среднесрочные обязательства',
			'ref_balance_item'=>15,
			'buttons'=>'yesno',
		],
		[
			'code'=>'init15',
			'article'=>16,
			'stage'=>'Пассивы - Долгосрочные обязательства',
			'ref_balance_item'=>16,
			'buttons'=>'yesno',
		],
	];
	
	public function getView($view) {
		if ($view == 'perform') return 'perform_init';
		return $view;
	}
	
	public function performStep($step)
	{
		if (parent::performStep($step)) {
			// ...custom code here...
			if ($step->code == 'init1') {
				if (BalanceSheet::find()->where(['user_id'=>Yii::$app->user->id])->count() == 0) {
					//init two months on the first step
					$model = new BalanceSheet();
					$model->prepareNext();
					if($model->save()) $model->initAmounts();
					$model = new BalanceSheet();
					$model->prepareNext();
					if($model->save()) $model->initAmounts();
				}
				if (BalanceItem::find()->where(['user_id'=>Yii::$app->user->id])->count() == 0) {
					$refs = RefBalanceItem::find()->where(['is_autogenerated'=>true])->all();
					foreach ($refs as $refItem) {
						$model = new BalanceItem();
						$model->prepareNew($refItem);
						$this->saveBalanceItem($step, $model);
					}
				}
			}
			return $this->createBalanceItem($step);
		} else {
			return false;
		}
	}
	
	public function RefBalanceItemForStep($step) {
		return RefBalanceItem::findOne($step->ref_balance_item);
	}
	
	public function KAForStep($step) {
		return KnowledgeArticle::findOne($step->article);
	}
	
	public function CurrentAmountLabelForStep($step) {
		$ref = $this->RefBalanceItemForStep($step);
		if ($ref != null) {
			if (!$ref->balanceType->isLiabilities()) return "Текущая сумма на счету";
			switch ($ref->balanceType->order_code) {
				case '2.1.' : return '';
				case '2.2.' : return 'Текущая зарезервированная сумма';
				case '2.3.' : return 'Текущая задолженность';
				case '2.4.' : return 'Текущие средства';
			}
		}
	}
	
	private function createBalanceItem($step)
	{
		if ($step->ref_balance_item > '') {
			$ref = $this->RefBalanceItemForStep($step);
			// create balance item
			$model = new BalanceItem();
			$model->prepareNew();
			$model->name = $ref->name;
			$model->balance_type_id = $ref->balance_type_id;
			$model->ref_balance_item_id = $ref->id;
			return $this->saveBalanceItem($step, $model);
		}
		return true;
	}
	
	private function saveBalanceItem($step, $model) {
		// save balance item
		if ($model->save()) {
			// create accounts and amounts (balance sheets already exist)
			$result = $model->initAccounts();
			if ($result) {
				// if accounts were not created
				$step->error = Json::encode($result);
				return false;
			} else {
				// if success, fill in the amount
				// supress notices for overloaded array - object references used and not set POST - rounded to zero
				@$model->accounts[0]->balanceAmounts[1]->amount = 0 + $_POST['init_value'];
				// save amount
				if(!$model->accounts[0]->balanceAmounts[1]->save()) {
					// if failed
					$step->error = Json::encode($model->accounts[0]->balanceAmounts[1]->errors);
					return false;
				}
			}
		} else {
			// if balance item was not saved
			$step->error = Json::encode($model->errors);
			return false;
		}
		return true;
	}
}
?>