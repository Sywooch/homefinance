<?php

namespace app\models;

use Yii;

/**
 * This is the extended model class for table "balance_item".
 *
 * @property integer $id
 * @property integer $order_num
 * @property string $order_code
 * @property string $name
 * @property integer $balance_type_id
 * @property integer $accounts_number
 *
 * @property Account[] $accounts
 * @property BalanceAmount[] $balanceAmounts
 * @property BalanceType $balanceType
 */
class BalanceItemExt extends BalanceItem
{
	private $balanceSheets;
	
	public static function primaryKey ()
	{
		return ['id'];
	}
	
	public static function tableName()
    {
        return 'balance_item';
    }
	
	public function getAmountByBSheet($bSheet_id)
	{
		if (isset($this->id)) {
			// if specific Item - return sum for all accounts
			return BalanceAmount::find()->
				joinWith('account')->
				where([
					'balance_item_id'=>$this->id,
					'balance_sheet_id'=>$bSheet_id,
				])->sum('amount');
		} else {
			//else return sum for all items of the same type and for all accounts
			return BalanceAmount::find()->
				joinWith('account')->
				joinWith('balanceItem')->
				where([
					'balance_type_id'=>$this->balance_type_id,
					'balance_sheet_id'=>$bSheet_id,
				])->sum('amount');
		}
	}
	
	public static function findTypesList()
	{
		return BalanceItemExt::find()->
			where(['user_id' => Yii::$app->user->id])->
			groupBy('user_id, balance_type_id')->
			select('user_id, balance_type_id')->
			orderBy('order_code');
	}
	
	public static function findByType($balance_type_id)
	{
		return BalanceItemExt::find()->
			where([
				'user_id' => Yii::$app->user->id,
				'balance_type_id' => $balance_type_id
			])->orderBy('order_code');
	}
}
