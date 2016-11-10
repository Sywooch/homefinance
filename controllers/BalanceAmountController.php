<?php

namespace app\controllers;

use Yii;
use app\models\BalanceAmount;
use app\models\BalanceItem;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BalanceAmountController implements the CRUD actions for BalanceAmount model.
 */
class BalanceAmountController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all BalanceAmount models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = Yii::$app->session;
		$session->open();
        $dataProvider = new ActiveDataProvider([
            'query' => BalanceAmount::find()
			->where(array('balance_sheet_id' => $session['balance_sheet_id']))
			->join('LEFT OUTER JOIN', 'account', 'balance_item_id = account.id')
			->orderBy('account.order_code'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BalanceAmount model.
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
     * Creates a new BalanceAmount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$session = Yii::$app->session;
		$session->open();
        $model = new BalanceAmount();

        if ($model->load(Yii::$app->request->post()) && $model->RecalcValues($session['balance_sheet_id']) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionCreateMaster($item_id, $sheet_id)
    {
        $item = BalanceItem::findOne($item_id);
		foreach ($item->accounts as $account) {
			$model = new BalanceAmount();
			$model->account_id = $account->id;
			$model->balance_sheet_id = $sheet_id;
			$model->amount = 0;
			$model->save();
		}
		return $this->redirect(['master/index']);
    }

    /**
     * Updates an existing BalanceAmount model.
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
	
	public function actionUpdateAmountAjax($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['balance-item/index']);
        }
    }

    /**
     * Deletes an existing BalanceAmount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BalanceAmount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BalanceAmount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BalanceAmount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
