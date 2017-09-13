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
 * @property integer $ref_balance_item_id
 *
 * @property Account[] $accounts
 * @property BalanceType $balanceType
 * @property User $user
 * @property RefBalanceItem $refBalanceItem
 */
class BalanceItem extends \yii\db\ActiveRecord
{
	public function afterFind()
    {
        parent::afterFind();
		if (Yii::$app->user->id != $this->user_id) {
			throw new \yii\web\ForbiddenHttpException('You are not allowed to access this item');
		}
    }
	
	public function getImmutable()
	{
		if ($this->refBalanceItem) {
			return $this->refBalanceItem->is_calculated;
		}
		return false;
	}
	
	public function prepareNew($refItem = null)
	{
		$this->user_id = Yii::$app->user->id;
		if ($refItem) {
			$this->ref_balance_item_id = $refItem->id;
			$this->name = $refItem->name;
			$this->balance_type_id = $refItem->balance_type_id;
		}
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
			$bSheets = BalanceSheet::find()->where(['user_id'=>$this->user_id])->all();
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
            [['order_num', 'balance_type_id', 'user_id', 'ref_balance_item_id'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45]
        ];
    }
	
	public function beforeValidate()
	{
		if (parent::beforeValidate()) {
			// ...custom code here...
			if ($this->order_num == null) {
				$this->order_num = BalanceItem::find()->where([
					'balance_type_id'=>$this->balance_type_id,
					'user_id'=>$this->user_id,
				])->max('order_num') + 1;
			}
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
            'order_code' => Yii::t('app', 'Order Code'),
            'name' => Yii::t('app', 'Name'),
            'balance_type_id' => Yii::t('app', 'Balance Type'),
            'user_id' => Yii::t('app', 'User'),
            'ref_balance_item_id' => 'Ref Balance Item',
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
	
	public function getBalanceTypeDict()
	{
		return BalanceType::find()->select(['name', 'id'])->orderBy('order_code')->indexBy('id')->column();
	}
	
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getUser() 
    { 
        return $this->hasOne(User::className(), ['id' => 'user_id']); 
    } 

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getRefBalanceItem()
   {
       return $this->hasOne(RefBalanceItem::className(), ['id' => 'ref_balance_item_id']);
   }
}
