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
			$this->order_code = $this->balanceItem->order_code . "." . $this->order_num;
			return true;
		} else {
			return false;
		}
	}
	
	public function RecalcValues()  
	{  
		$this->order_num = 1;
		return true;  
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
