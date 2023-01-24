<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PageSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'page_id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'slug') ?>

    <?= $form->field($model, 'page_order') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'page_type') ?>

    <?php // echo $form->field($model, 'show_on_footer') ?>

    <?php // echo $form->field($model, 'show_on_header') ?>

    <?php // echo $form->field($model, 'external_url') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
