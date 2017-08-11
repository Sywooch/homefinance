<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\BasicProcess;
use app\models\InitWizard;
use yii\filters\AccessControl;

class ProcessController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
	
    public function actionPerform($process_code, $step_code)
    {
		$model = $this->findModel($process_code);
		$current_step = $model->getStep($step_code);
		$req = \Yii::$app->request;
		if ($req->method == "POST" &&
			($req->post('answer') == 'no' || $model->performStep($current_step))) {
			//step passed successfully
			if ($model->hasNext($step_code)) {
				//next step
				$current_step = $model->getNext($step_code);
				return $this->redirect(['perform', 'process_code'=>$process_code, 'step_code'=>$current_step->code]);
			} else {
				return $this->redirect(['review', 'process_code'=>$process_code]);
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
