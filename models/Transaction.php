<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $amount
 * @property integer $from_item_id
 * @property integer $to_item_id
 * @property string $date
 *
 * @property BalanceItem $fromItem
 * @property BalanceItem $toItem
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date'], 'required'],
            [['amount'], 'number'],
            [['from_item_id', 'to_item_id'], 'integer'],
            [['date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'from_item_id' => 'From Item ID',
            'to_item_id' => 'To Item ID',
            'date' => 'Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFromItem()
    {
        return $this->hasOne(BalanceItem::className(), ['id' => 'from_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToItem()
    {
        return $this->hasOne(BalanceItem::className(), ['id' => 'to_item_id']);
    }
}
