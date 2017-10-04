<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_sheet".
 *
 * @property integer $id
 * @property string $period_start
 * @property integer $user_id
 *
 * @property BalanceAmount[] $balanceAmounts
 * @property User $user
 */
class BalanceSheet extends \yii\db\ActiveRecord
{
	public function afterFind()
    {
        parent::afterFind();
		if (Yii::$app->user->id != $this->user_id) {
			throw new \yii\web\ForbiddenHttpException('You are not allowed to access this item');
		}
    }
	
	private $_threshold;
	private static $cathedLastSheets;
	
	public function getThreshold() {
		if (!($this->_threshold > "")) {
			$this->_threshold = SystemSettings::loadValue('balance_threshold');
		}
		return $this->_threshold;
	}
	
	public static function NotSet()
	{
		$model = new BalanceSheet();
		$model->period_start = "not set";
		return $model;
	}
	
	public static function LastTwo()
	{
		return static::LastN(2);
	}
	
	public static function LastN($count)
	{
		//check cache
		if (isset(static::$cathedLastSheets) && 
			isset(static::$cathedLastSheets[$count]) && 
			static::$cathedLastSheets[$count][0]->user_id == Yii::$app->user->id)
			return static::$cathedLastSheets[$count];
		//or prepare new
		$balanceSheets = BalanceSheet::find()->
			where(['user_id'=>Yii::$app->user->id])->
			orderBy('period_start DESC')->
			limit($count)->all();
		while (count($balanceSheets) < $count) $balanceSheets[] = BalanceSheet::NotSet();
		static::$cathedLastSheets[$count] = $balanceSheets;
		return $balanceSheets;
	}
	
	public function getTotal($balance_type_category_id)
	{
		return $this->getBalanceAmounts()
		->join('INNER JOIN', 'balance_item', 'account.balance_item_id = balance_item.id')
		->join('INNER JOIN', 'balance_type', 'balance_item.balance_type_id = balance_type.id')
		->where(['balance_type.balance_type_category_id' => $balance_type_category_id])
		->sum('balance_amount.amount');
	}

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period_start', 'user_id'], 'required'],
            [['period_start'], 'safe'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period_start' => Yii::t('app', 'Period Start'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceAmounts()
    {
        return $this->hasMany(BalanceAmount::className(), ['balance_sheet_id' => 'id'])->joinWith('account')->orderBy('account.order_code');
    }
	
	/**
	For each account create an item. If previous balance sheet exists and has value - set it as default, otherwise - set to zero
	*/
	public function initAmounts()
	{
		$accounts = Account::find()->joinWith('balanceItem')->where(['user_id'=>$this->user_id])->orderBy('order_code')->all();
		$prevBalance = $this->getPreviousBalance();
		for ($i = 0; $i < count($accounts); $i++) {
			$amount = new BalanceAmount();
			$amount->account_id = $accounts[$i]->id;
			$amount->balance_sheet_id = $this->id;
			$amount->amount = $prevBalance ? $prevBalance->balanceAmounts[$i]->amount : 0;
			$amount->save();
		}
	}
	
	public function getPreviousBalance()
	{
		return BalanceSheet::find()
			->where(['<','period_start',$this->period_start])
			->andWhere(['user_id'=>$this->user_id])
			->orderBy('period_start DESC')
			->limit(1)
			->one();
	}
	
	public function prepareNext()
	{
		$this->user_id = Yii::$app->user->id;
		$last = BalanceSheet::find()->where(['user_id'=>$this->user_id])->orderBy('period_start DESC')->limit(1)->one();
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
		$results = @Yii::$app->db->createCommand("
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
			) - amntNew.amount AS Result
		FROM {{%balance_item}} AS item
			LEFT OUTER JOIN {{%ref_balance_item}} AS ref ON item.ref_balance_item_id = ref.id
			LEFT OUTER JOIN {{%account}} AS acc ON item.id = acc.balance_item_id
			LEFT OUTER JOIN {{%balance_amount}} AS amntOld ON acc.id = amntOld.account_id
			LEFT OUTER JOIN {{%balance_amount}} AS amntNew ON acc.id = amntNew.account_id
			LEFT OUTER JOIN {{%transaction}} AS transFrom ON transFrom.account_from_id = acc.id
			LEFT OUTER JOIN {{%transaction}} AS transTo ON transTo.account_to_id = acc.id
		WHERE
			(ref.id IS NULL OR ref.is_calculated = false)
			AND amntOld.balance_sheet_id = :old_id
			AND amntNew.balance_sheet_id = :new_id
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
		for ($i = 0; $i < count($results); $i++)
			$results[$i]['threshold'] = ($results[$i]['Result'] > $this->threshold) ? 'over' : 'in';
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
