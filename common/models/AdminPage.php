<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%admin_page}}".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $config_name
 * @property string|null $config_value
 * @property int|null $sort_order
 * @property int|null $status
 *
 * @property AdminPage $parent
 * @property AdminPage[] $adminPages
 */
class AdminPage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order', 'status'], 'integer'],
            [['config_name', 'config_value'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminPage::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'config_name' => Yii::t('app', 'Config Name'),
            'config_value' => Yii::t('app', 'Config Value'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(AdminPage::className(), ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[AdminPages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAdminPages()
    {
        return $this->hasMany(AdminPage::className(), ['parent_id' => 'id'])->andWhere(['status' => 1,'on_top' => 1])->orderBy('sort_order');
    }

    public function getMenus(){
        return AdminPage::find()->where(['parent_id' => $this->id,'status' => 1,'on_top' => 1])->orderBy('sort_order')->all();
    }
}
