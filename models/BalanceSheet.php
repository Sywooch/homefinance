<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_sheet".
 *
 * @property integer $id
 * @property string $period_start
 * @property integer $is_month
 * @property integer $user_id
 *
 * @property BalanceAmount[] $balanceAmounts
 * @property User $user
 */
class BalanceSheet extends \yii\db\ActiveRecord
{
	public static function NotSet()
	{
		$model = new BalanceSheet();
		$model->period_start = "not set";
		return $model;
	}
	
	public static function LastTwo()
	{
		$balanceSheets = BalanceSheet::find()->select('id, period_start')->orderBy('period_start DESC')->limit(2)->all();
		while (count($balanceSheets) < 2) $balanceSheets[] = BalanceSheet::NotSet();
		return $balanceSheets;
	}
	
	public function getTotal($is_active)
	{
		return $this->getBalanceAmounts()
		->join('INNER JOIN', 'balance_item', 'account.balance_item_id = balance_item.id')
		->join('INNER JOIN', 'balance_type', 'balance_item.balance_type_id = balance_type.id')
		->where(['balance_type.is_active' => $is_active])
		->sum('balance_amount.amount');
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period_start', 'is_month', 'user_id'], 'required'],
            [['period_start'], 'safe'],
            [['is_month', 'user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period_start' => 'Period Start',
            'is_month' => 'Is Month',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceAmounts()
    {
        return $this->hasMany(BalanceAmount::className(), ['balance_sheet_id' => 'id'])->join('INNER JOIN', 'account', 'balance_amount.account_id = account.id')->orderBy('account.order_code');
    }
	
	/**
	For each account create an item. If previous balance sheet exists and has value - set it as default, otherwise - set to zero
	*/
	public function initAmounts()
	{
		$accounts = Account::find()->orderBy('order_code')->all();
		$prevBalance = $this->getPreviouBalance();
		for ($i = 0; $i < count($accounts); $i++) {
			$amount = new BalanceAmount();
			$amount->account_id = $accounts[$i]->id;
			$amount->balance_sheet_id = $this->id;
			$amount->amount = $prevBalance ? $prevBalance->balanceAmounts[$i]->amount : 0;
			$amount->save();
		}
	}
	
	private function getPreviouBalance()
	{
		return BalanceSheet::find()
			->where(['<','period_start',$this->period_start])
			->orderBy('period_start DESC')
			->limit(1)
			->one();
	}
	
	public function prepareNext()
	{
		$this->is_month = true;
		$this->user_id = 1;
		$last = BalanceSheet::find()->orderBy('period_start DESC')->limit(1)->one();
		if ($last) {
			$this->period_start = date("Y-m-d", strtotime("+1 month", strtotime($last->period_start)));
		} else {
			$this->period_start = (new \DateTime('first day of previous month'))->format("Y-m-d");
		}
	}
	
	public function getChangeVerification()
	{
		//get previous sheet
		$prev = $this->getPreviouBalance();
		if ($prev == null) return false;
		//get joined list of balance items with their values
		//get list of transactions between sheets dates and calculate expected results
		$results = Yii::$app->db->createCommand("
		SELECT
			item.id,
			item.order_code,
			item.name,
			amntOld.amount AS AmountOLD,
			amntNew.amount AS AmountNEW,
			IFNULL(sum(transFrom.amount) * count(DISTINCT transFrom.id) / count(transFrom.id), 0) AS Decrease,
			IFNULL(sum(transTo.amount) * count(DISTINCT transTo.id) / count(transTo.id), 0) AS Increase,
			(amntOld.amount - 
				IFNULL((sum(transFrom.amount) * count(DISTINCT transFrom.id) / count(transFrom.id)), 0) + 
				IFNULL((sum(transTo.amount) * count(DISTINCT transTo.id) / count(transTo.id)), 0)
			) - amntNew.amount AS Balance
		FROM {{%balance_item}} AS item
			LEFT OUTER JOIN {{%balance_amount}} AS amntOld ON item.id = amntOld.balance_item_id AND amntOld.balance_sheet_id = :old_id
			LEFT OUTER JOIN {{%balance_amount}} AS amntNew ON item.id = amntNew.balance_item_id AND amntNew.balance_sheet_id = :new_id
			LEFT OUTER JOIN {{%transaction}} AS transFrom ON transFrom.from_item_id = item.id
			LEFT OUTER JOIN {{%transaction}} AS transTo ON transTo.to_item_id = item.id
		GROUP BY
			item.id,
			item.order_code,
			item.name,
			amntOld.amount,
			amntNew.amount
		ORDER BY
			item.order_code
		")
		->bindParam(':old_id', $prev->id)
		->bindParam(':new_id', $this->id)
		->queryAll();
		return $results;
	}
	
	 /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
