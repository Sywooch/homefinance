<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_amount".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $balance_sheet_id
 * @property integer $account_id
 *
 * @property Account $account
 * @property BalanceSheet $balanceSheet
 */
class BalanceAmount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'balance_sheet_id', 'account_id'], 'required'],
            [['amount'], 'number'],
            [['balance_sheet_id', 'account_id'], 'integer']
        ];
    }
	
	public function RecalcValues($balance_sheet_id)  
	{  
		$this->balance_sheet_id = $balance_sheet_id;  
		return true;  
	} 

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'balance_sheet_id' => 'Balance Sheet ID',
            'account_id' => 'Account ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceSheet()
    {
        return $this->hasOne(BalanceSheet::className(), ['id' => 'balance_sheet_id']);
    }
}
