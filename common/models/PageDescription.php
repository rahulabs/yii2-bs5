<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%page_description}}".
 *
 * @property int $description_id
 * @property int|null $language_id
 * @property int $page_id
 * @property string $title
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keyword
 *
 * @property Page $page
 * @property Language $language
 */
class PageDescription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%page_description}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language_id', 'page_id'], 'integer'],
            [['page_id', 'title'], 'required'],
            [['description'], 'string'],
            [['title', 'meta_title', 'meta_description', 'meta_keyword'], 'string', 'max' => 255],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'page_id']],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Language::className(), 'targetAttribute' => ['language_id' => 'language_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'description_id' => Yii::t('app', 'Description ID'),
            'language_id' => Yii::t('app', 'Language ID'),
            'page_id' => Yii::t('app', 'Page ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'meta_keyword' => Yii::t('app', 'Meta Keyword'),
        ];
    }

    /**
     * Gets query for [[Page]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['page_id' => 'page_id']);
    }

    /**
     * Gets query for [[Language]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLanguage()
    {
        return $this->hasOne(Language::className(), ['language_id' => 'language_id']);
    }
}
