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
	public function afterFind()
    {
        parent::afterFind();
		if (Yii::$app->user->id != $this->balanceSheet->user_id) {
			throw new \yii\web\ForbiddenHttpException('You are not allowed to access this item');
		}
    }
	
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
	
	public function afterSave($insert, $changed) {
		$this->recalcCurrentAmount();
	}

	private function recalcCurrentAmount()
	{
		//get item with specific ref id
		$currentAmount = $this->balanceSheet->getBalanceAmounts()->
			//joinWith('account')->
			leftJoin('balance_item', 'balance_item.id = account.balance_item_id')->
			where(['balance_item.ref_balance_item_id'=>9])->one();
		if (!$currentAmount) {
			Yii::warning("Current Amount not found");
			return;
		}
		if ($currentAmount->id == $this->id) return;
		//count diff assets-liabilities+current for selected balance sheet
		$newAmount = $this->balanceSheet->getTotal(1) - $this->balanceSheet->getTotal(2) + $currentAmount->amount;
		//set current value to that diff for selected balance sheet
		$currentAmount->amount = $newAmount;
		$currentAmount->save();
	}
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => Yii::t('app', 'Amount'),
            'balance_sheet_id' => Yii::t('app', 'Balance Sheet'),
            'account_id' => Yii::t('app', 'Account'),
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
    public function getBalanceItem()
    {
        return $this->hasOne(BalanceItem::className(), ['id' => 'balance_item_id'])->via('account');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceSheet()
    {
        return $this->hasOne(BalanceSheet::className(), ['id' => 'balance_sheet_id']);
    }
}
