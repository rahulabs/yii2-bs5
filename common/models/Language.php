<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%language}}".
 *
 * @property int $language_id
 * @property string $name
 * @property string $code
 * @property string $locale
 * @property string $image
 * @property int $sort_order
 * @property int $status
 */
class Language extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%language}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'code', 'locale', 'image', 'status'], 'required'],
            [['sort_order', 'status'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['code'], 'string', 'max' => 5],
            [['locale'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 64],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'language_id' => Yii::t('app', 'Language ID'),
            'name' => Yii::t('app', 'Name'),
            'code' => Yii::t('app', 'Code'),
            'locale' => Yii::t('app', 'Locale'),
            'image' => Yii::t('app', 'Image'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
