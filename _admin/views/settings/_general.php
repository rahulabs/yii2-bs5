<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'config_website_url')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'config_name')->textInput(['maxlength' => 255]) ?>
    </div>
    <div class="w-100"></div>

    <div class="col-sm-6">
        <?= $form->field($model, 'config_logo')->widget(\lgxenos\yii2\imgSelector\ImageSelector::className());  ?>
    </div>
    <div class="w-100"></div>

    <div class="col-sm-6">
        <?= $form->field($model, 'config_emails')->textarea(['rows'=>2])->hint('Enter emails with comma(,) separated values.') ?>
    </div>

    <div class="col-sm-6">
        <?= $form->field($model, 'config_analytic')->textarea(['rows'=>2]) ?>
    </div>
</div>