<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_to_pages}}".
 *
 * @property int $id
 * @property int $role_id
 * @property int $menu_id
 * @property int|null $parent_id
 */
class UserToPages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_to_pages}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id', 'parent_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'menu_id' => Yii::t('app', 'Menu ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
        ];
    }
}
