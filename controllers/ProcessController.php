<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\BasicProcess;
use app\models\InitWizard;

class ProcessController extends Controller
{
    public function actionPerform($process_code, $step_code)
    {
		$model = $this->findModel($process_code);
		$current_step = null;
		for ($i = 0; $i < count($model->steps); $i++) {
			if ($model->steps[$i]->code == $step_code) {
				$current_step = $model->steps[$i];
				break;
			}
		}
		$req = \Yii::$app->request;
		if ($req->method == "POST" &&
			($req->post('answer') == 'no' || $model->performStep($current_step))) {
			//step passed successfully
			if ($i == count($model->steps) - 1) {
				return $this->redirect(['review', 'process_code'=>$process_code]);
			} else {
				//next step
				$current_step = $model->steps[$i + 1];
				return $this->redirect(['perform', 'process_code'=>$process_code, 'step_code'=>$current_step->code]);
			}
		}
        return $this->render($model->getView('perform'), [
			'model'=>$model,
			'step'=>$current_step,
		]);
    }

    public function actionReview($process_code)
    {
		$model = $this->findModel($process_code);
        return $this->render($model->getView('review'), [
			'model'=>$model,
		]);
    }

    public function actionStart($process_code)
    {
		$model = $this->findModel($process_code);
        return $this->render($model->getView('start'), [
			'model'=>$model,
		]);
    }
	
    protected function findModel($code)
    {
        if ($code == 'init') {
			$model = new InitWizard();
        } else {
            $model = new BasicProcess();
        }
		$model->init();
		return $model;
    }
}
