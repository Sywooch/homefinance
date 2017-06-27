<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\JSON;

class TransactionUploadForm extends Model
{
    public $field_amount;
    public $field_date;
    public $field_date_format;
	public $field_description;
	public $inverse_signs;
	public $csv_separator;
	public $decimal_separator;
	public $operation_account_id;
	public $csv_file;
	
	public function loadValues() {
		//TODO fetch user_id
		$user_id = 1;
		$model = ImportSettings::find()->where(['user_id'=>$user_id, 'code'=>'import'])->one();
		if ($model) {
			$this->setAttributes(JSON::decode($model->payload));
		} else {
			$this->field_amount = 'amount';
			$this->field_date = 'date';
			$this->field_date_format = 'd/m/Y';
			$this->field_description = 'description';
			$this->csv_separator = ',';
			$this->decimal_separator = '.';
		}
	}
	
	public function getAvailableAccounts() {
		return Account::find()->where("order_code LIKE '1%'")->select('name, id')->indexBy('id')->column();
	}

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['field_amount', 'field_date', 'field_date_format', 'csv_separator', 'decimal_separator', 'operation_account_id', 'csv_file'], 'required'],
			[['field_description', 'inverse_signs'], 'safe']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
			//save current settings
			//TODO fetch user_id
			$user_id = 1;
			$model = ImportSettings::find()->where(['user_id'=>$user_id, 'code'=>'import'])->one();
			if ($model == null) {
				$model = new ImportSettings();
				$model->user_id = $user_id;
				$model->code = 'import';
				$model->name = 'import';
			}
			//set payload without file
			$file = $this->csv_file;
			$this->csv_file = null;
			$model->payload = JSON::encode($this);
			$this->csv_file = $file;
			if (!$model->save()) {
				echo JSON::encode($model->errors);
				die();
			}
			//parse file
			$parsers = Transaction::getAllImportRulesDecoded();
			$file = new \SplFileObject($this->csv_file[0]->tempName);
			$headers = [];
			//first line => parse headers
			if (!$file->eof()) {
				$columns = $file->fgetcsv($this->csv_separator);
				$cntcol = count($columns);
				for ($j = 0; $j < $cntcol; $j++) {
					if (trim($columns[$j]) == $this->field_amount) $headers['field_amount'] = $j;
					if (trim($columns[$j]) == $this->field_date) $headers['field_date'] = $j;
					if (trim($columns[$j]) == $this->field_description) $headers['field_description'] = $j;
				}
			}
			$i = 0;
			//parse rest of the file
			while (!$file->eof()) {
				$i++;
				$columns = $file->fgetcsv($this->csv_separator);
				$model = new Transaction();
				//TODO apply decimal_separator
				$model->amount = $columns[$headers['field_amount']];
				$model->for_review = true;
				if ($this->inverse_signs) $model->amount = -$model->amount;
				if ($this->field_description > '') $model->description = trim($columns[$headers['field_description']]);
				$dt = \DateTime::createFromFormat($this->field_date_format, $columns[$headers['field_date']]);
				$model->date = $dt->format("Y-m-d H:i:s");
				if ($model->amount < 0) {
					$model->amount = -$model->amount;
					$model->account_from_id = $this->operation_account_id;
				} else {
					$model->account_to_id = $this->operation_account_id;
				}
				foreach ($parsers as $rule) if ($model->applyImportRule($rule)) break;
				//TODO apply parsers
				if (!$model->save()) {
					$this->addError('csv_file', "Failed line $i: ".\yii\helpers\JSON::encode($model->errors));
				}
			}
			$file = null;
			//TODO model errors + try-catch
			if ($this->errors) return false;
            else return true;
        } else {
            return false;
        }
    }
}
