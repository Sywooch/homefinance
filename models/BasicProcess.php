<?php

namespace app\models;

use Yii;
use yii\base\Model;

class BasicProcess extends Model
{
	public $code = 'tp';
	public $title = 'Test process';
	public $description = 'This is the process for demo purposes';
	public $finishMessage = 'Thanks for your input';
	public $finishLink = ['Home', ['site/index']];
	public $steps = [
		[
			'code'=>'ts1',
			'title'=>'test step 1',
			'message'=>'perform test step 1',
		],
		[
			'code'=>'ts2',
			'title'=>'test step 2',
			'message'=>'perform test step 2',
		],
	];
	
	public function init() {
		for ($i = 0; $i < count($this->steps); $i++) {
			$this->steps[$i] = (object)$this->steps[$i];
		}
	}
	
	public function getView($view) {
		return $view;
	}
	
	/**
	**** to override method use code: ****
	public function performStep($step)
	{
		if (parent::performStep($step)) {
			// ...custom code here...
			return true;
		} else {
			return false;
		}
	}
	*/
	public function performStep($step) {
		//$step->error = "error message";
		//return false;
		return true;
	}
	
	private function getStepIndex($step_code)
	{
		for ($i = 0; $i < count($this->steps); $i++) {
			if ($this->steps[$i]->code == $step_code) {
				return $i;
			}
		}
		return 0;
	}
	
	public function getStep($step_code)
	{
		return $this->steps[$this->getStepIndex($step_code)];
	}
	
	public function hasNext($step_code)
	{
		return $this->steps[count($this->steps) - 1]->code != $step_code;
	}
	
	public function getNext($step_code)
	{
		return $this->steps[$this->getStepIndex($step_code) + 1];
	}
}
?>