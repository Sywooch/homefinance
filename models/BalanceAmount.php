<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_amount".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $balance_item_id
 * @property integer $balance_sheet_id
 *
 * @property BalanceItem $balanceItem
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
            [['amount', 'balance_item_id', 'balance_sheet_id'], 'required'],
            [['amount'], 'number'],
            [['balance_item_id', 'balance_sheet_id'], 'integer']
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
            'balance_item_id' => 'Balance Item ID',
            'balance_sheet_id' => 'Balance Sheet ID',
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
    public function getBalanceSheet()
    {
        return $this->hasOne(BalanceSheet::className(), ['id' => 'balance_sheet_id']);
    }
}
