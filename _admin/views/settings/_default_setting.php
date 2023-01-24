<?php
use kartik\select2\Select2;
$data = [];
if(!empty($model->config_objects))
    $model->config_objects = explode(',',$model->config_objects);
?>
<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'config_objects')->widget(Select2::classname(),['data' => [],
            'options' => [ 'multiple' => true ],
            'pluginOptions' => [
                    'tags' => true,
                'tokenSeparators' => [',', ' '],
                ],
            ])->hint('(Use Enter or Space for new hashtag or ID)') ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_multiple_tags')->dropDownList([0 => 'No',1 => 'Yes']) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'config_layout')->radioList([1 => 'Grid style',2 => 'Masonry style']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_cowork_message')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_dm_message')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_asking_price')->dropDownList([0 => 'No',1 => 'Yes']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_fixed_price')->textInput(['maxlength' => 255]) ?>
    </div>
</div>