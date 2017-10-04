<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property integer $id
 * @property integer $order_num
 * @property string $order_code
 * @property string $name
 * @property integer $balance_item_id
 *
 * @property BalanceItem $balanceItem
 * @property BalanceAmount[] $balanceAmounts
 * @property Transaction[] $transactions
 * @property Transaction[] $transactions0
 */
class Account extends \yii\db\ActiveRecord
{	
	private $balanceSheets;
	
	public function getAmountModel($sheet_id)
	{
		$amount = BalanceAmount::find()->where([
			'account_id'=>$this->id,
			'balance_sheet_id'=>$sheet_id,
		])->one();
		if ($amount) return $amount;
		else return null;
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_num', 'balance_item_id'], 'required'],
            [['order_num', 'balance_item_id'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45]
        ];
    }
	
	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
			// ...custom code here...
			if ($this->order_num == null) $this->order_num = Account::find()->where(['balance_item_id'=>$this->balance_item_id])->max('order_num') + 1;
			$this->order_code = $this->balanceItem->order_code . "." . $this->order_num;
			return true;
		} else {
			return false;
		}
	}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_num' => 'Order Num',
            'order_code' => 'Order Code',
            'name' => 'Name',
            'balance_item_id' => 'Balance Item ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceItem()
    {
        return $this->hasOne(BalanceItem::className(), ['id' => 'balance_item_id']);
    }
	
   /**
     * @return \yii\db\ActiveQuery
     */
   public function getBalanceAmounts()
   {
       return $this->hasMany(BalanceAmount::className(), ['account_id' => 'id']);
   }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['account_from_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions0()
    {
        return $this->hasMany(Transaction::className(), ['account_to_id' => 'id']);
    }
}
