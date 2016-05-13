<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
        return $this->hasMany(BalanceItemExt::className(), ['balance_type_id' => 'id'])->where(['OR',['period_start'=>ArrayHelper::getColumn(Yii::$app->session['balanceSheets'], 'period_start')],['period_start'=>null]]);
    }
}
