<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "import_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $payload
 * @property integer $user_id
 *
 * @property User $user
 */
class ImportSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'payload', 'user_id', 'code'], 'required'],
            [['user_id'], 'integer'],
            [['name', 'code'], 'string', 'max' => 45],
            [['payload'], 'string', 'max' => 1024],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
			'code' => 'Code',
            'payload' => 'Payload',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
