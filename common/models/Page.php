<?php

namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%page}}".
 *
 * @property int $page_id
 * @property int|null $parent_id
 * @property string $slug
 * @property int $page_order
 * @property int $status
 * @property int $page_type
 * @property int $show_on_footer
 * @property int $show_on_header
 * @property string|null $external_url
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int $is_delete
 *
 * @property PageDescription[] $pageDescriptions
 */
class Page extends \yii\db\ActiveRecord
{
    public $title;
    public $description;
    public $meta_title;
    public $meta_description;
    public $meta_keyword;

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
        return '{{%page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'page_order', 'status', 'page_type', 'show_on_footer', 'show_on_header', 'created_at', 'updated_at','is_delete'], 'integer'],
            [['title', 'description'], 'required','on' => ['create','update']],
            [['page_order', 'status','slug'], 'required'],
            [['external_url'], 'string'],
            [['slug'], 'unique'],
            [['slug'], 'string', 'max' => 255],
            [['title', 'description', 'meta_title', 'meta_description', 'meta_keyword','external_url'], 'trim'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::class, 'targetAttribute' => ['parent_id' => 'page_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'page_id' => Yii::t('app', 'Page ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'slug' => Yii::t('app', 'Slug'),
            'page_order' => Yii::t('app', 'Page Order'),
            'status' => Yii::t('app', 'Status'),
            'page_type' => Yii::t('app', 'Page Type'),
            'show_on_footer' => Yii::t('app', 'Show On Footer'),
            'show_on_header' => Yii::t('app', 'Show On Header'),
            'external_url' => Yii::t('app', 'External Url'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[PageDescriptions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPageDescriptions()
    {
        return $this->hasMany(PageDescription::class, ['page_id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Page::class, ['page_id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Page::className(), ['parent_id' => 'page_id']);
    }

    public function getPageDescription()
    {
        return $this->hasOne(PageDescription::className(), ['page_id' => 'page_id'])->andWhere(['language_id' => language_id]);
    }

    public function getPagesDescriptions()
    {
        return $this->hasMany(PageDescription::className(), ['page_id' => 'page_id']);
    }

    public function getPagesDescription()
    {
        $all_languages = Language::find()->where(['status' => 1])->asArray()->all();

        $flags = [];
        foreach ($all_languages as $all_language):
            $flag = Html::img(Yii::$app->request->baseUrl.'/images/flags/'.$all_language['image'],['class' => 'img-fluid','alt' => $all_language['name'],'title' => $all_language['name'], 'style' => 'width:30px;height:100%;border-radius:0;']);
            $flags[$all_language['language_id']] = $flag;
        endforeach;

        $descriptions =  $this->hasMany(PageDescription::className(), ['page_id' => 'page_id'])->all();
        $html = [];
        $title = $desc = $meta_title = $meta_description = $meta_keyword =  '';
        foreach ($descriptions as $description){
            $title .= '<p class="m-0">'.$flags[$description->language_id].' '.$description->title.'</p>';
            $desc .= '<p class="m-0">'.$flags[$description->language_id].' '.$description->description.'</p>';
            $meta_title .= '<p class="m-0">'.$flags[$description->language_id].' '.$description->meta_title.'</p>';
            $meta_description .= '<p class="m-0">'.$flags[$description->language_id].' '.$description->meta_description.'</p>';
            $meta_keyword .= '<p class="m-0">'.$flags[$description->language_id].' '.$description->meta_keyword.'</p>';
        }
        $html['title'] = $title;
        $html['description'] = $desc;
        $html['meta_title'] = $meta_title;
        $html['meta_description'] = $meta_description;
        $html['meta_keyword'] = $meta_keyword;
        return $html;
    }

    public function getPageUrl(){
        if($this->external_url!=''){
            return $this->external_url;
        }
        if($this->page_type===0)
            return Url::to(Yii::$app->request->baseUrl.'/pages/'.$this->slug,true);
        return Url::to(Yii::$app->request->baseUrl.'/'.$this->slug,true);
    }
}
