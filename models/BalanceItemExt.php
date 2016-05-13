<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_item".
 *
 * @property integer $id
 * @property integer $order_num
 * @property string $order_code
 * @property string $name
 * @property integer $balance_type_id
 *
 * @property Account[] $accounts
 * @property BalanceAmount[] $balanceAmounts
 * @property BalanceType $balanceType
 */
class BalanceItemExt extends BalanceItem
{
	private static $use_view = true;
		
	public static function tableName()
    {
        return BalanceItemExt::$use_view ? 'v_balance_item' : 'balance_item';
    }
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			BalanceItemExt::$use_view = false;
			return true;
		} else {
			return false;
		}
	}	
	
	public function afterSave($insert, $changedAttributes)
	{
		if (parent::afterSave($insert, $changedAttributes)) {
			BalanceItemExt::$use_view = true;
			return true;
		} else {
			return false;
		}
	}
	
	public function showCreateLink($sheet) {
		return yii\helpers\Html::a("create", array("balance-amount/create-master", "item_id"=>$this->id, 'sheet_id'=>$sheet->id));
	}
}
