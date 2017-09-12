<?php

namespace app\controllers;

use Yii;
use app\models\BalanceSheet;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BalanceSheetController implements the CRUD actions for BalanceSheet model.
 */
class BalanceSheetController extends Controller
{
    public function behaviors()
    {
        return [
			'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all BalanceSheet models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BalanceSheet::find()->where(['user_id' => Yii::$app->user->id])->orderBy('period_start DESC'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionOpen($id){
		$session = Yii::$app->session;
		$session->open();
		$session['balance_sheet_id'] = $id;
		$session['balance_sheet_date'] = $this->findModel($id)->period_start;
		$this->redirect(array('balance-amount/index'));
	}

    /**
     * Displays a single BalanceSheet model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BalanceSheet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BalanceSheet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreateNext()
	{
		$model = new BalanceSheet();
		$model->prepareNext();
		
		if($model->save()) {
			$model->initAmounts();
			return $this->redirect(['balance-item/index']);
		} else
			var_dump($model->errors);
	}

    /**
     * Updates an existing BalanceSheet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BalanceSheet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionVerifyChange($id)
	{
		if (($model = $this->findModel($id)) && ($result = $model->getChangeVerification()))
		{
			$dataProvider = new ArrayDataProvider([
				'allModels' => $result
			]);
			return $this->render('verify', [
				'model' => $model,
				'dataProvider' => $dataProvider,
			]);
		}
		else 
		{
			echo "fail";
		}
	}

    /**
     * Finds the BalanceSheet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BalanceSheet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BalanceSheet::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
