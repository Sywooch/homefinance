<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $auth_key
 * @property string $auth_token
 * @property string $create_datetime
 *
 * @property BalanceItem[] $balanceItems
 * @property BalanceSheet[] $balanceSheets
 * @property ImportSettings[] $importSettings
 * @property Transaction[] $transactions
 * @property UserSettings[] $userSettings
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{	
	public static function findIdentity($id)
	{
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }
	
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	}

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($auth_key)
    {
        return $this->auth_key === $auth_key;
    }
	
	public function validatePassword($password)
	{
		return $this->password === crypt($password, $this->password);
	}
	
	public function getIsAdmin() {
		return $this->username == 'admin';
	}
	
	public function beforeSave($insert) {
		if (parent::beforeSave($insert)) {
			// ...custom code here...
			if($this->password > '') $this->password = crypt($this->password, "$1$".rand());
			else unset($this->password);
			return true;
		} else {
			return false;
		}
	}
	
	public function login() {
		return Yii::$app->user->login($this, 0);
	}
	
	public function dropData() {
		$list = BalanceItem::find()->where(['user_id'=>$this->id])->all();
		foreach ($list as $item) $item->delete();
		$list = BalanceSheet::find()->where(['user_id'=>$this->id])->all();
		foreach ($list as $item) $item->delete();
		$list = UserSettings::find()->where(['user_id'=>$this->id])->all();
		foreach ($list as $item) $item->delete();
		$list = ImportSettings::find()->where(['user_id'=>$this->id])->all();
		foreach ($list as $item) $item->delete();
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'], 'required', 'on'=>'register'],
			[['username', 'email'], 'required'],
            [['username', 'password', 'email'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_id' => 'Auth ID',
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => 'Email',
            'auth_key' => 'Auth Key',
            'auth_token' => 'Auth Token',
			'create_datetime' => Yii::t('app', 'Register Datetime'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceItems()
    {
        return $this->hasMany(BalanceItem::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBalanceSheets()
    {
        return $this->hasMany(BalanceSheet::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportSettings()
    {
        return $this->hasMany(ImportSettings::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::className(), ['user_id' => 'id']);
    }
}
