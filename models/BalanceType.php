<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_type".
 *
 * @property integer $id
 * @property integer $is_det
 * @property integer $is_active
 * @property string $order_code
 * @property string $name
 *
 * @property BalanceItem[] $balanceItems
 */
class BalanceType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'balance_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_det', 'order_code', 'name'], 'required'],
            [['is_det', 'is_active'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'is_det' => 'Is Det',
            'is_active' => 'Is Active',
            'order_code' => 'Order Code',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceItems()
    {
        return $this->hasMany(BalanceItem::className(), ['balance_type_id' => 'id']);
    }
}
