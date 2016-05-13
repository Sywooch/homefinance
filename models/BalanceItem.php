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
class BalanceItem extends \yii\db\ActiveRecord
{	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_num', 'order_code', 'name', 'balance_type_id'], 'required'],
            [['order_num', 'balance_type_id'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45]
        ];
    }
	
	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
			// ...custom code here...
			$this->order_code = $this->balanceType->order_code . $this->order_num;
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
            'balance_type_id' => 'Balance Type ID',
        ];
    }
	
	public function RecalcValues()  
	{  
		if ($this->order_num == null) $this->order_num = BalanceItem::find()->where(['balance_type_id'=>$this->balance_type_id])->max('order_num') + 1;
		return true;  
	}
	
	/**
    * @return \yii\db\ActiveQuery
    */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['balance_item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceType()
    {
        return $this->hasOne(BalanceType::className(), ['id' => 'balance_type_id']);
    }
}
