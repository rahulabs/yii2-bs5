<?php


namespace common\models;
use Yii;


class Settings extends \yii\db\ActiveRecord
{
    public $config_name;
    public $config_logo;
    public $config_title;
    public $config_meta_description;
    public $config_meta_keywords;
    public $config_analytic;
    public $config_website_url;
    public $config_emails;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {

        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settings_key'], 'required'],

            [['config_name','config_website_url'], 'string'],
            [['settings_key'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'settings_key' => 'Settings Key',
            'settings_value' => 'Settings Value',
            'config_tax' => yii::t('yii','Tax (%)'),
            'config_emails' => yii::t('yii','Admin email address'),
            'config_name' => yii::t('yii','Website Name'),
            'config_logo' => yii::t('yii','Website Logo'),
            'config_title' => yii::t('yii','Website Meta Title'),
            'config_meta_description' => yii::t('yii','Website Meta Description'),
            'config_meta_keywords' => yii::t('yii','Website Meta Keyword'),
            'config_analytic'=>yii::t('yii','Google Analytics Code'),
            'config_website_url'=>yii::t('yii','Website url'),
            'config_paypal_client_id'=>yii::t('yii','Client id'),
            'config_paypal_secret_id'=>yii::t('yii','Secret id'),
            'config_paypal_status'=>yii::t('yii','Status'),
            'config_paypal_env'=>yii::t('yii','Environment'),
            'config_token'=>yii::t('yii','API Token'),
        ];
    }
}