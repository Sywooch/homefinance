<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_sheet".
 *
 * @property integer $id
 * @property string $period_start
 * @property integer $is_month
 *
 * @property BalanceAmount[] $balanceAmounts
 */
class BalanceSheet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance_sheet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['period_start', 'is_month'], 'required'],
            [['period_start'], 'safe'],
            [['is_month'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'period_start' => 'Period Start',
            'is_month' => 'Is Month',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceAmounts()
    {
        return $this->hasMany(BalanceAmount::className(), ['balance_sheet_id' => 'id']);
    }
	
	public function getChangeVerification()
	{
		//get previous sheet
		$prev = BalanceSheet::find()
			->where(['<','period_start',$this->period_start])
			->orderBy('period_start DESC')
			->limit(1)
			->one();
		if ($prev == null) return false;
		//get joined list of balance items with their values
		//get list of transactions between sheets dates and calculate expected results
		$results = Yii::$app->db->createCommand("
		SELECT
			item.id,
			item.order_code,
			item.name,
			amntOld.amount AS AmountOLD,
			amntNew.amount AS AmountNEW,
			sum(transFrom.amount) * count(DISTINCT transFrom.id) / count(transFrom.id) AS Decrease,
			sum(transTo.amount) * count(DISTINCT transTo.id) / count(transTo.id) AS Increase,
			amntNew.amount - 
				(amntOld.amount - 
				(sum(transFrom.amount) * count(DISTINCT transFrom.id) / count(transFrom.id)) + 
				(sum(transTo.amount) * count(DISTINCT transTo.id) / count(transTo.id))
				) AS Balance
		FROM balance_item AS item
			LEFT OUTER JOIN balance_amount AS amntOld ON item.id = amntOld.balance_item_id AND amntOld.balance_sheet_id = :old_id
			LEFT OUTER JOIN balance_amount AS amntNew ON item.id = amntNew.balance_item_id AND amntNew.balance_sheet_id = :new_id
			LEFT OUTER JOIN transaction AS transFrom ON transFrom.from_item_id = item.id
			LEFT OUTER JOIN transaction AS transTo ON transTo.to_item_id = item.id
		GROUP BY
			item.id,
			item.order_code,
			item.name,
			amntOld.amount,
			amntNew.amount
		ORDER BY
			item.order_code
		")
		->bindParam(':old_id', $prev->id)
		->bindParam(':new_id', $this->id)
		->queryAll();
		return $results;
	}
}
