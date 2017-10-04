<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
			'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }
	
	public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        $email = $attributes['emails'][0]['value'];
        $id = $attributes['id'];
        $nickname = $attributes['displayName'];
		
		$user = User::findIdentity($id);
		if (Yii::$app->user->isGuest) {
            if ($user) { // login
				Yii::$app->user->login($user);
            } else { // signup
                if ($email !== null && User::find()->where(['email' => $email])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('app', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                } else {
                    //$password = Yii::$app->security->generateRandomString(6);
                    $user = new User([
						'auth_id' => $id,
                        'username' => $nickname,
                        'email' => $email,
                        //'password_hash' => $password,
                    ]);

                    if ($user->save()) {
						Yii::$app->user->login($user);
                    } else {
                        Yii::$app->getSession()->setFlash('error', [
                            Yii::t('app', 'Unable to save user: {errors}', [
                                'client' => $client->getTitle(),
                                'errors' => json_encode($user->getErrors()),
                            ]),
                        ]);
						echo json_encode($user->getErrors());
						die();
                    }
                }
            }
        } else { // user already logged in
			/** @var User $user */
			//$user = $auth->user;
			Yii::$app->getSession()->setFlash('success', [
				Yii::t('app', 'Linked {client} account.', [
					'client' => $client->getTitle()
				]),
			]);
        }
    }

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
			$this->layout = 'landing';
			return $this->render('landing-index');
		} else if (Yii::$app->user->identity->getBalanceItems()->count() == 0) {
			$this->layout = 'landing';
			return $this->render('landing-index2');
		} else return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionDrop()
	{
		$list = \app\models\BalanceItem::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
		foreach ($list as $item) $item->delete();
		$list = \app\models\BalanceSheet::find()->where(['user_id'=>Yii::$app->user->identity->id])->all();
		foreach ($list as $item) $item->delete();
		return $this->redirect(['index']);
	}
}
