<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'config_instagram_username')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_instagram_password')->passwordInput(['maxlength' => 255,'value' => '']) ?>
    </div>
</div>