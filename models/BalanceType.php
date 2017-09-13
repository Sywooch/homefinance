<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "balance_type".
 *
 * @property integer $id
 * @property string $order_code
 * @property string $name
 * @property integer $balance_type_category_id
 *
 * @property BalanceItem[] $balanceItems
 * @property BalanceTypeCategory $balanceTypeCategory
 * @property RefBalanceItem[] $refBalanceItems
 */
class BalanceType extends \yii\db\ActiveRecord
{
	public function isAssets() {
		return $this->balance_type_category_id == 1;
	}
	public function isLiabilities() {
		return $this->balance_type_category_id == 2;
	}
	public function isOuterAssets() {
		return $this->balance_type_category_id == 3;
	}
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_code', 'name', 'balance_type_category_id'], 'required'],
            [['balance_type_category_id'], 'integer'],
            [['order_code', 'name'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_code' => 'Order Code',
            'name' => 'Name',
			'balance_type_category_id' => 'Balance Type Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceItems()
    {
        return $this->hasMany(BalanceItemExt::className(), ['balance_type_id' => 'id']);
    }
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getBalanceTypeCategory()
	{
	   return $this->hasOne(BalanceTypeCategory::className(), ['id' => 'balance_type_category_id']);
	}
	public function getBalanceTypeCategoryDict()
	{
		return BalanceTypeCategory::find()->select(['name', 'id'])->indexBy('id')->column();
	}
	
	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getRefBalanceItems()
	{
	   return $this->hasMany(RefBalanceItem::className(), ['balance_type_id' => 'id']);
	}
}
