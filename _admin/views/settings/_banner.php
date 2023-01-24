<?php
use kartik\select2\Select2;

?>
<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'enable_banner')->widget(Select2::classname(), [
            'data' => [ 'no' => 'No', 'yes' => 'Yes']]) ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'mobile_banner')->widget(\lgxenos\yii2\imgSelector\ImageSelector::className());  ?>
    </div>
    <div class="col-sm-4">
        <?= $form->field($model, 'web_banner')->widget(\lgxenos\yii2\imgSelector\ImageSelector::className());  ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'banner_link')->textInput(['maxlength' => 255]) ?>
    </div>
</div>