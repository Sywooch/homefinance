<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "system_settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property string $value
 *
 * @property UserSettings[] $userSettings
 */
class SystemSettings extends \yii\db\ActiveRecord
{
	public static function loadValue($code) {
		$val = $model = SystemSettings::find()->where(['code'=>$code])->select('value')->scalar();
		if ($val) return $val;
		else throw new NotFoundHttpException("System Settings with code '$code' was not found");
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'code', 'value'], 'required'],
            [['name', 'code', 'value'], 'string', 'max' => 45],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSettings()
    {
        return $this->hasMany(UserSettings::className(), ['system_settings_id' => 'id']);
    }
}
