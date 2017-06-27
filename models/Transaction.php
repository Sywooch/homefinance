<?php

namespace app\models;

use Yii;
use yii\helpers\JSON;

/**
 * This is the model class for table "transaction".
 *
 * @property integer $id
 * @property string $amount
 * @property string $description
 * @property string $category
 * @property string $sub_category
 * @property string $date
 * @property integer $for_review
 * @property integer $account_from_id
 * @property integer $account_to_id
 * @property integer $user_id
 *
 * @property Account $accountFrom
 * @property Account $accountTo
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
	public $description_trigger;
	
	public function getName() {
		return $this->amount . ' from '.$this->date;
	}
	
	public function createImportRule() {
		$model = new ImportSettings();
		$this->description_trigger = trim($this->description_trigger);
		$model->name = $this->description_trigger;
		$model->code = 'parser';
		$model->user_id = $this->user_id;
		$model->payload = JSON::encode([
			'trigger'=>$this->description_trigger,
			'category'=>$this->category,
			'sub_category'=>$this->sub_category
		]);
		if ($model->save()) {
			$model->payload = JSON::decode($model->payload);
			return $model;
		}
		return false;
	}
	
	public function applyImportRule($rule_decoded) {
		//TODO change to contains
		if ($this->description == $rule_decoded->payload['trigger']) {
			$this->category = $rule_decoded->payload['category'];
			$this->sub_category = $rule_decoded->payload['sub_category'];
			$this->for_review = false;
			return true;
		}
		return false;
	}
	
	public static function getAllImportRulesDecoded() {
		//TODO fetch user_id
		$user_id = 1;
		$rules = ImportSettings::find()->where(['user_id'=>$user_id, 'code'=>'parser'])->all();
		for ($i = 0; $i < count($rules); $i++) {
			$rules[$i]->payload = JSON::decode($rules[$i]->payload);
		}
		return $rules;
	}
	
	public static function findForReview() {
		//TODO fetch user_id
		$user_id = 1;
		return static::find()->where(['user_id'=>$user_id, 'for_review'=>true])->all();
	}
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'date', 'user_id'], 'required'],
            [['amount'], 'number'],
            [['date', 'description_trigger'], 'safe'],
            [['account_from_id', 'account_to_id'], 'integer'],
            [['description', 'category', 'sub_category'], 'string', 'max' => 255]
        ];
    }
	
	public function BeforeValidate() {
		//TODO setup user_id
		if (!$this->user_id) $this->user_id = 1;
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
            'description' => 'Description',
            'category' => 'Category',
			'sub_category' => 'Sub Category',
            'date' => 'Date',
            'account_from_id' => 'Account From ID',
            'account_to_id' => 'Account To ID',
			'user_id' => 'User ID', 
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
