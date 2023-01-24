<div class="row">
    <div class="col-sm-12">
        <?= $form->field($model, 'config_title')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'config_meta_description')->textarea(['rows' => 2]) ?>
    </div>
    <div class="col-sm-12">
        <?= $form->field($model, 'config_meta_keywords')->textarea(['rows' => 2]) ?>
    </div>
</div>