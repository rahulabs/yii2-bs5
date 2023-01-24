<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%301_redirect}}".
 *
 * @property int $id
 * @property string $from
 * @property string $to
 * @property int $redirect_type
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Redirect extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%301_redirect}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'redirect_type'], 'required'],
            [['to'], 'string'],
            [['to'], 'url'],
            [['redirect_type', 'created_at', 'updated_at'], 'integer'],
            [['from'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'from' => Yii::t('app', 'From'),
            'to' => Yii::t('app', 'To'),
            'redirect_type' => Yii::t('app', 'Redirect Type'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
