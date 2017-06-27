<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "knowledge_article".
 *
 * @property integer $id
 * @property string $name
 * @property string $full_text
 * @property string $image_url
 *
 * @property RefBalanceItem[] $refBalanceItems
 */
class KnowledgeArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'knowledge_article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['full_text'], 'string'],
            [['name'], 'string', 'max' => 45],
            [['image_url'], 'string', 'max' => 255],
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
            'full_text' => 'Full Text',
            'image_url' => 'Image Url',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRefBalanceItems()
    {
        return $this->hasMany(RefBalanceItem::className(), ['knowledge_article_id' => 'id']);
    }
}
