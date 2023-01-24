<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_role}}".
 *
 * @property int $role_id
 * @property int $is_delete
 * @property string $name
 * @property string $permission
 */
class UserRole extends \yii\db\ActiveRecord
{
    public $menu_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_role}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['is_delete'], 'integer'],
            [['permission','menu_id'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'role_id' => Yii::t('app', 'Role ID'),
            'name' => Yii::t('app', 'Name'),
            'permission' => Yii::t('app', 'Permission'),
        ];
    }
}
