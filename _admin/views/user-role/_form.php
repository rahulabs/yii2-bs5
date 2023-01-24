<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\AdminPage;
use common\models\UserToPages;

/* @var $this yii\web\View */
/* @var $model common\models\UserRole */
/* @var $form yii\widgets\ActiveForm */
$all_menus = ArrayHelper::map(AdminPage::find()->where(['and',['main_module' => 1],['status'=>1]])->orderBy('sort_order ASC')->asArray()->all(), 'id', 'config_name');
$main_menus = ArrayHelper::map(AdminPage::find()->where(['status' => 1,'on_top' => 1,'parent_id' => null])->orderBy('sort_order ASC')->asArray()->all(), 'id', 'config_name');

if($model->permission){
    $all_permissions = unserialize($model->permission);
    $model->permission = $all_permissions;
}
$selected_menus = [];
$all_pages = UserToPages::find()->where(['role_id' => $model->role_id])->all();
if($all_pages){
    foreach ($all_pages as $all_page){
        if($all_page->parent_id){
            $selected_menus[] = $all_page->parent_id.'_'.$all_page->menu_id;
        }else{
            $selected_menus[] = $all_page->menu_id;
        }
    }

}
?>

<div class="user-role-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4 <?= $permissions ? 'd-none' : '' ?>">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="w-100"></div>
        <?php foreach ($main_menus as $k => $main_menu){
            $menus = ArrayHelper::map(AdminPage::find()->where(['status' => 1,'on_top' => 1,'parent_id' => $k])->orderBy('sort_order ASC')->asArray()->all(), 'id', 'config_name');
            $checked = 0;
            if(in_array($k,$selected_menus)){
                $checked = 1;
            }
            ?>
            <div class="col-sm-3 mb-2">
                <div class="card" style="min-height:200px;">
                    <div class="card-body">
                        <?php
                        if($checked){
                            echo $form->field($model, 'menu_id[]')->checkbox(['value' => $k,'id' => $k,'checked' => 1])->label($main_menu);
                        }else{
                            echo $form->field($model, 'menu_id[]')->checkbox(['value' => $k,'id' => $k])->label($main_menu);
                        }
                        ?>

                        <?php foreach ($menus as $l => $menu){
                            $checked = 0;
                            if(in_array($k.'_'.$l,$selected_menus)){
                                $checked = 1;
                            }
                            ?>
                            <div class="mb-0 ms-2">
                                <?php if($checked){
echo $form->field($model, 'menu_id[]')->checkbox(['value' => $k.'_'.$l,'id' => $k.'_'.$l,'checked' => 1])->label($menu);
                                }else{
                                    echo $form->field($model, 'menu_id[]')->checkbox(['value' => $k.'_'.$l,'id' => $k.'_'.$l])->label($menu);
                                } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        <?php } ?>
    </div>

    <div class="form-group mb-3">
        <?= Html::submitButton(Yii::t('app', '<i class="fas fa-save"></i> Save'), ['class' => 'btn btn-dark']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
