<?php

namespace app\controllers;

use Yii;
use app\models\Transaction;
use app\models\TransactionUploadForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * TransactionController implements the CRUD actions for Transaction model.
 */
class TransactionController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Transaction models.
     * @return mixed
     */
    public function actionIndex()
    {
		//TODO extract user_id
		$user_id = 1;
        $dataProvider = new ActiveDataProvider([
            'query' => Transaction::find()->where(['user_id'=>$user_id])->orderBy('date DESC'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Transaction model.
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
     * Creates a new Transaction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Transaction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Transaction model.
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
	
    public function actionUpload()
    {
		$model = new TransactionUploadForm();
		$model->loadValues();
		
        if ($model->load(Yii::$app->request->post())) {
			$model->csv_file = UploadedFile::getInstances($model, 'csv_file');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['index']);
            }
        }
		return $this->render('upload', [
			'model' => $model,
		]);
    }
	
    public function actionReview($id)
    {
        $model = $this->findModel($id);
		$model->description_trigger = $model->description;
		$model->for_review = false;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if ($_POST['action'] == 'Save and Apply') {
				if ($rule = $model->createImportRule()) {
					//apply created rule
					$transactions = Transaction::findForReview();
					foreach ($transactions as $tran) if ($tran->applyImportRule($rule)) $tran->save();
				}
			}
            return $this->redirect(['index']);
        } else {
            return $this->render('review', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Transaction model.
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
     * Finds the Transaction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Transaction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Transaction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
