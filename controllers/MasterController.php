<?php

namespace app\controllers;

use app\models\BalanceItem;
use app\models\BalanceType;
use app\models\BalanceSheet;
use app\models\BalanceAmount;
use app\models\Account;
use Yii;

class MasterController extends \yii\web\Controller
{
    public function actionAddBalanceItem()
    {
		$model = new BalanceItem();

        if ($model->load(Yii::$app->request->post()) && $model->RecalcValues() && $model->save()) {
			$account = new Account();
			$account->name = $model->name;
			$account->balance_item_id = $model->id;
			if ($account->RecalcValues() && $account->save())
				foreach (Yii::$app->session['balanceSheets'] as $sheet) {
					$amount = new BalanceAmount();
					$amount->account_id = $account->id;
					$amount->balance_sheet_id = $sheet->id;
					$amount->amount = 0;
					$amount->save();
				}
				return $this->redirect(['index']);
        } else {
			$model->balance_type_id = Yii::$app->request->get('type_id');
            return $this->render('add-balance-item', [
                'model' => $model,
            ]);
        }
		
        return $this->render('add-balance-item');
    }

    public function actionAddBalanceSheet()
    {
        return $this->render('add-balance-sheet');
    }

    public function actionDetailsBalanceItem($item_id)
    {
		$item = BalanceItem::findOne($item_id);
        return $this->render('details-balance-item', array('item'=>$item));
    }

    public function actionIndex()
    {
		$balanceTypes = BalanceType::find()->orderBy('order_code')->all();
		$balanceSheets = BalanceSheet::find()->select('id, period_start')->orderBy('period_start DESC')->limit(2)->all();
		Yii::$app->session['balanceSheets'] = $balanceSheets;
        return $this->render('index', ['balanceTypes'=>$balanceTypes, 'balanceSheets'=>$balanceSheets]);
    }

    public function actionRemoveBalanceItem($id)
    {
        BalanceItem::findOne($id)->delete();
		return $this->redirect(['index']);
    }

    public function actionUpdateBalanceItem()
    {
        return $this->render('update-balance-item');
    }

    public function actionUpdateBalanceSheet()
    {
        return $this->render('update-balance-sheet');
    }

}
