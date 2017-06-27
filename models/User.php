<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $login
 *
 * @property BalanceItem[] $balanceItems
 * @property BalanceSheet[] $balanceSheets
 * @property ImportSettings[] $importSettings
 * @property Transaction[] $transactions
 * @property UserSettings[] $userSettings
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
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
            [['login'], 'required'],
            [['login'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
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
