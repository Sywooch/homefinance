<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $amount
 * @property string $description
 * @property string $date
 * @property integer $account_from_id
 * @property integer $account_to_id
 *
 * @property Account $accountFrom
 * @property Account $accountTo
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
            [['date'], 'safe'],
            [['account_from_id', 'account_to_id'], 'integer'],
            [['description'], 'string', 'max' => 255]
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
            'description' => 'Description',
            'date' => 'Date',
            'account_from_id' => 'Account From ID',
            'account_to_id' => 'Account To ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountFrom()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountTo()
    {
        return $this->hasOne(Account::className(), ['id' => 'account_to_id']);
    }
}
