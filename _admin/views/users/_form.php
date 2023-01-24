<?php

use common\models\UserRole;
use kartik\select2\Select2;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */

if ($model->other_roles) {
    $model->other_roles = explode(',', $model->other_roles);
}
$user_roles = UserRole::find()->where(['NOT IN', 'role_id' ,2])->asArray()->all();
if ( in_array(2, all_roles, true) ){
    $user_roles = UserRole::find()->asArray()->all();
}
?>

<div class="users-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-sm-3">
            <?=
                $form->field($model, 'role_id')->widget(Select2::class, [
                    'data' => ArrayHelper::map($user_roles, 'role_id', 'name'),
                    'options' => ['placeholder' => 'Please select'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])
            ?>
        </div>
        <div class="col-sm-6">
            <?=
            $form->field($model, 'other_roles')->widget(Select2::class, [
                'data' => ArrayHelper::map(UserRole::find()->where(['NOT IN', 'role_id' ,2])->asArray()->all(), 'role_id', 'name'),
                'options' => ['placeholder' => 'Please select', 'multiple' => true],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList([10 => 'Active',9 => 'In active'],['class' => 'form-select']) ?>
        </div>

        <div class="col-sm-3"></div>

        <div class="form-group col-sm-12 mt-3">
            <?= Html::submitButton('<i class="fas fa-save"></i> '.(($model->isNewRecord) ? 'Save' : 'Update'), ['class' => 'btn btn-outline-dark mb-3 btn-sm']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
