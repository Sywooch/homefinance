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
 * @property integer $user_id
 * @property integer $immutable
 *
 * @property Account[] $accounts
 * @property BalanceAmount[] $balanceAmounts
 * @property BalanceType $balanceType
 * @property User $user
 */
class BalanceItem extends \yii\db\ActiveRecord
{
	public function prepareNew()
	{
		$this->user_id = 1;
	}
	
	public function initAccounts()
	{
		//create default account for balance Item
		$account = new Account();
		$account->name = $this->name;
		$account->balance_item_id = $this->id;
		$errors = [];
		if ($account->save()) {
			//for all existed balance items create amount for default account
			$bSheets = BalanceSheet::find()->all();
			$success = true;
			foreach ($bSheets as $sheet) {
				if (isset($sheet->id)) {
					$amount = new BalanceAmount();
					$amount->account_id = $account->id;
					$amount->balance_sheet_id = $sheet->id;
					$amount->amount = 0;
					if (!$amount->save()) {
						$success = false;
						$errors['amount'] = $amount->errors;
					}
				}
			}
			if ($success) return false;
		} else {
			$errors['account'] = $account->errors;
		}
		$errors['message'] = "Errors in BalanceItem::initAccounts()";
		return $errors;
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_num', 'order_code', 'name', 'balance_type_id', 'user_id'], 'required'],
            [['order_num', 'balance_type_id', 'user_id', 'immutable'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45]
        ];
    }
	
	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
			// ...custom code here...
			if ($this->order_num == null) $this->order_num = BalanceItem::find()->where(['balance_type_id'=>$this->balance_type_id])->max('order_num') + 1;
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
            'balance_type_id' => 'Balance Type',
            'user_id' => 'User ID',
            'immutable' => 'Immutable',
        ];
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
	
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getUser() 
    { 
        return $this->hasOne(User::className(), ['id' => 'user_id']); 
    } 
}
