<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $value
 * @property integer $system_settings_id
 * @property integer $user_id
 *
 * @property SystemSettings $systemSettings
 * @property User $user
 */
class UserSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'value', 'system_settings_id', 'user_id'], 'required'],
            [['system_settings_id', 'user_id'], 'integer'],
            [['name', 'code', 'value'], 'string', 'max' => 45],
            [['system_settings_id'], 'exist', 'skipOnError' => true, 'targetClass' => SystemSettings::className(), 'targetAttribute' => ['system_settings_id' => 'id']],
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
            'value' => 'Value',
            'system_settings_id' => 'System Settings ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSystemSettings()
    {
        return $this->hasOne(SystemSettings::className(), ['id' => 'system_settings_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
